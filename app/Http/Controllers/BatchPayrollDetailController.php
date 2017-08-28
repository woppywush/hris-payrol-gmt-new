<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Models\MasterPegawai;
use App\Models\MasterKomponenGaji;
use App\Models\PrKomponenGajiDetail;
use App\Models\PrBatchPayrollDetail;

use Excel;
use PHPExcel_Worksheet_Drawing;
use PHPExcel_Worksheet_PageSetup;

class BatchPayrollDetailController extends Controller
{
    /**
    * Authentication controller.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function getdatakomponen($idbatch, $idpegawai)
    {
      $getid = PrBatchPayrollDetail::select('id')
                          ->where('id_batch_payroll', $idbatch)
                          ->where('id_pegawai', $idpegawai)
                          ->first();

      $getkomponengaji = PrKomponenGajiDetail::select('pr_komponen_gaji_detail.id as id', 'nama_komponen', 'tipe_komponen', 'periode_perhitungan', 'nilai')
                          ->join('master_komponen_gaji', 'master_komponen_gaji.id', 'pr_komponen_gaji_detail.id_komponen_gaji')
                          ->where('id_batch_payroll_detail', $getid->id)->get();

      return $getkomponengaji;
    }

    public function addtodetailkomponen($idbatch, $idpegawai, $idkomponen, $nilai)
    {
      $getid = PrBatchPayrollDetail::select('id')
                          ->where('id_batch_payroll', $idbatch)
                          ->where('id_pegawai', $idpegawai)
                          ->first();

      $set = new PrKomponenGajiDetail;
      $set->id_batch_payroll_detail = $getid->id;
      $set->id_komponen_gaji = $idkomponen;
      $set->nilai = $nilai;
      $set->save();

      $getkomponengaji = PrKomponenGajiDetail::select('pr_komponen_gaji_detail.id as id', 'nama_komponen', 'tipe_komponen', 'periode_perhitungan', 'nilai')
                          ->join('master_komponen_gaji', 'master_komponen_gaji.id', 'pr_komponen_gaji_detail.id_komponen_gaji')
                          ->where('id_batch_payroll_detail', $getid->id)->get();

      return $getkomponengaji;
    }

    public function cekkomponen($idbatch, $idpegawai)
    {
      $getid = PrBatchPayrollDetail::select('id')
                    ->where('id_batch_payroll', $idbatch)
                    ->where('id_pegawai', $idpegawai)
                    ->first();

      $cek = PrKomponenGajiDetail::where('id_batch_payroll_detail', $getid->id)->get();
      return $cek;
    }

    public function getgajipokok($idpegawai)
    {
      $get = MasterPegawai::find($idpegawai);

      return $get->gaji_pokok;
    }

    public function deletekomponengaji($id)
    {
      $set = PrKomponenGajiDetail::find($id);
      $set->delete();

      return $set;
    }

    public function bindforabsen($id)
    {
      $getdata = PrBatchPayrollDetail::
            select('pr_batch_payroll_detail.id', 'master_pegawai.nip', 'master_pegawai.nama', 'abstain', 'sick_leave', 'permissed_leave')
            ->join('master_pegawai', 'pr_batch_payroll_detail.id_pegawai', '=', 'master_pegawai.id')
            ->where('pr_batch_payroll_detail.id', $id)
            ->first();

      return $getdata;
    }

    public function updateforabsen(Request $request)
    {
      $set = PrBatchPayrollDetail::find($request->id);
      $set->abstain = $request->abstain;
      $set->sick_leave = $request->sick_leave;
      $set->permissed_leave = $request->permissed_leave;
      $set->save();

      return redirect()->route('batchpayroll.detail', $request->idperiode)->with('message', 'Data absen berhasil diperbarui.');
    }

    public function export($idbatch)
    {
      $getbatchpayroll = PrBatchPayrollDetail::
        select('pr_batch_payroll_detail.id', 'master_pegawai.nip', 'master_pegawai.nama')
        ->join('master_pegawai', 'pr_batch_payroll_detail.id_pegawai', '=', 'master_pegawai.id')
        ->where('pr_batch_payroll_detail.id_batch_payroll', $idbatch)
        ->get();

      $getkomponengaji = MasterKomponenGaji::
        select('id', 'nama_komponen', 'tipe_komponen')
        ->where('tipe_komponen_gaji', 1)
        ->where('flag_status', 1)
        ->get();

      $generateabsenpegawai = array();
      $generatepenerimaanvariable = array();
      $generatepotonganvariable = array();
      foreach ($getbatchpayroll as $key) {
        $rowdata = array();
        $rowdata['id'] = $key->id;
        $rowdata['nip'] = $key->nip;
        $rowdata['nama'] = $key->nama;
        $rowdata['alpa'] = 0;
        $rowdata['sakit'] = 0;
        $rowdata['izin'] = 0;
        $generateabsenpegawai[] = $rowdata;

        $rowgaji = array();
        $rowgaji['id'] = $key->id;
        $rowgaji['nip'] = $key->nip;
        $rowgaji['nama'] = $key->nama;

        $rowpotongan = array();
        $rowpotongan['id'] = $key->id;
        $rowpotongan['nip'] = $key->nip;
        $rowpotongan['nama'] = $key->nama;

        foreach ($getkomponengaji as $gkj) {
          if ($gkj->tipe_komponen=='D') {
            $rowgaji["$gkj->nama_komponen"] = 0;
          } else {
            $rowpotongan["$gkj->nama_komponen"] = 0;
          }
        }
        $generatepenerimaanvariable[] = $rowgaji;
        $generatepotonganvariable[] = $rowpotongan;
      }

      Excel::create('GMT-Batch-Payroll-Template', function($excel) use($generateabsenpegawai, $generatepenerimaanvariable, $generatepotonganvariable, $getkomponengaji) {
        /// --- SHEET ABSENSI ---
        $excel->sheet('Absensi Pegawai', function($sheet) use($generateabsenpegawai) {
          $sheet->row(1, array('SYSTEM ID', 'NIP', 'NAMA', 'ALPA', 'SAKIT', 'IZIN'));
          $sheet->cells('A1:F1', function($cells) {
            $cells->setBackground('#3c8dbc');
            $cells->setFontColor('#ffffff');
          });
          $sheet->fromArray($generateabsenpegawai, null, 'A2', true, false);
        });
        /// --- END OF SHEET ABSENSI ---

        /// --- SHEET PENERIMAAN VARIABLE ---
        $excel->sheet('Penerimaan Variable', function($sheet) use($generatepenerimaanvariable, $getkomponengaji) {
          $colgajivariable = array();
          $colgajivariable[] = "SYSTEM_ID";
          $colgajivariable[] = "NIP";
          $colgajivariable[] = "NAMA";
          $count = 0;
          foreach ($getkomponengaji as $key) {
            if ($key->tipe_komponen=="D") {
              $colgajivariable[] = $key->id." // ".$key->nama_komponen;
              $count++;
            }
          }
          $header = $count+2;
          $alphabeth = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G',
            'H', 'I', 'J', 'K', 'L', 'M', 'N',
            'O', 'P', 'Q', 'R', 'S', 'T', 'U',
            'V', 'W', 'X', 'Y', 'Z'
          ];
          $sheet->row(1, $colgajivariable);
          $sheet->cells("A1:$alphabeth[$header]1", function($cells){
            $cells->setBackground('#3c8dbc');
            $cells->setFontColor('#ffffff');
          });
          $sheet->fromArray($generatepenerimaanvariable, null, 'A2', true, false);
        });
        /// --- END OF SHEET PENERIMAAN VARIABLE ---

        $excel->sheet('Potongan Variable', function($sheet) use($generatepotonganvariable, $getkomponengaji) {
          $colpotonganvariable = array();
          $colpotonganvariable[] = "SYSTEM_ID";
          $colpotonganvariable[] = "NIP";
          $colpotonganvariable[] = "NAMA";
          $count = 0;
          foreach ($getkomponengaji as $key) {
            if ($key->tipe_komponen=="P") {
              $colpotonganvariable[] = $key->id." // ".$key->nama_komponen;
              $count++;
            }
          }
          $header = $count+2;
          $alphabeth = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G',
            'H', 'I', 'J', 'K', 'L', 'M', 'N',
            'O', 'P', 'Q', 'R', 'S', 'T', 'U',
            'V', 'W', 'X', 'Y', 'Z'
          ];
          $sheet->row(1, $colpotonganvariable);
          $sheet->cells("A1:$alphabeth[$header]1", function($cells){
            $cells->setBackground('#3c8dbc');
            $cells->setFontColor('#ffffff');
          });
          $sheet->fromArray($generatepotonganvariable, null, 'A2', true, false);
        });
      })->export('xls');
    }

    public function import() {
      $timestamps = date('Y-m-d h:m:s');
      $idbatch = 0;
      if(Input::hasFile('filecsv')) {
        $path = Input::file('filecsv')->getRealPath();

        // --- IMPORT SHEET ABSENSI ---
        $dataabsensi = Excel::selectSheets('Absensi Pegawai')->load($path, function($reader) {})->get();
        if(!empty($dataabsensi) && $dataabsensi->count()){
          foreach ($dataabsensi as $key) {
            if ($key->system_id!=null) {
              $set = PrBatchPayrollDetail::find($key->system_id);
              $set->abstain = $key->alpa;
              $set->sick_leave = $key->sakit;
              $set->permissed_leave = $key->izin;
              $set->save();
              $idbatch = $set->id_batch_payroll;
            }
          }
        }
        // --- IMPORT SHEET ABSENSI ---

        // --- IMPORT GAJI VARIABLE ---
        $datagajivariable = Excel::selectSheets('Penerimaan Variable')->load($path, function($reader) {})->get()->toArray();
        if(!empty($datagajivariable) && count($datagajivariable)) {
          foreach ($datagajivariable as $key) {
            $x = array_keys($key);
            $y = array_values($key);
            for ($i=3; $i < count($x); $i++) {
              if ($key["system_id"]!=null) {
                if ($y[$i]!=0) {
                  $idexplode = explode("_", $x[$i]);
                  $set = new PrKomponenGajiDetail;
                  $set->id_batch_payroll_detail = $key["system_id"];
                  $set->id_komponen_gaji = $idexplode[0];
                  $set->nilai = $y[$i];
                  $set->save();
                }
              }
            }
          }
        }
        // --- END OF IMPORT GAJI VARIABLE ---

        // --- IMPORT POTONGAN VARIABLE ---
        $datapotonganvariable = Excel::selectSheets('Potongan Variable')->load($path, function($reader) {})->get()->toArray();
        if(!empty($datapotonganvariable) && count($datapotonganvariable)) {
          foreach ($datapotonganvariable as $key) {
            $x = array_keys($key);
            $y = array_values($key);
            for ($i=3; $i < count($x); $i++) {
              if ($key["system_id"]!=null) {
                if ($y[$i]!=0) {
                  $idexplode = explode("_", $x[$i]);
                  $set = new PrKomponenGajiDetail;
                  $set->id_batch_payroll_detail = $key["system_id"];
                  $set->id_komponen_gaji = $idexplode[0];
                  $set->nilai = $y[$i];
                  $set->save();
                }
              }
            }
          }
        }
        // --- END OF IMPORT POTONGAN VARIABLE ---
      } else {
        return redirect()->route('batchpayroll.detail', $idbatch)->with('messagefailed', 'Mohon upload file .xls anda.');
      }

      return redirect()->route('batchpayroll.detail', $idbatch)->with('message', 'Berhasil melakukan import data.');
    }


    public function ubahtipepembayaran($id)
    {
      $set = PrBatchPayrollDetail::find($id);
      // dd($set);
      if($set->tipe_pembayaran=="1") {
        $set->tipe_pembayaran = 0;
        $set->save();
      } elseif ($set->tipe_pembayaran=="0") {
        $set->tipe_pembayaran = 1;
        $set->save();
      }

      return redirect()->route('batchpayroll.detail', $set->id_batch_payroll)->with('message', 'Tipe Pembayaran berhasil diperbarui.');
    }
}
