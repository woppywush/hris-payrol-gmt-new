<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\MasterPegawai;
use App\Models\MasterClient;
use App\Models\MasterClientCabang;
use App\Models\MasterBank;
use App\Models\MasterKomponenGaji;
use App\Models\MasterHariLibur;

use App\Models\HrPkwt;

use App\Models\PrBpjs;
use App\Models\PrPeriodeGaji;
use App\Models\PrBatchPayroll;
use App\Models\PrBatchProcessed;
use App\Models\PrKomponenGajiTetap;
use App\Models\PrPeriodeGajiDetail;
use App\Models\PrKomponenGajiDetail;
use App\Models\PrBatchPayrollDetail;

use DB;
use Excel;

class BatchPayrollLaporanController extends Controller
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

    public function prosesSPV($id)
    {
        // Get Data Supervisi Pegawwai
        $getSPV = HrPkwt::join('pr_batch_payroll_detail', 'pr_batch_payroll_detail.id_pegawai', '=', 'hr_pkwt.id_pegawai')
                        ->join('master_pegawai', 'master_pegawai.id', '=', 'hr_pkwt.id_kelompok_jabatan')
                        ->select('master_pegawai.nama','pr_batch_payroll_detail.id_pegawai', 'hr_pkwt.id_kelompok_jabatan')
                        ->where('pr_batch_payroll_detail.id_batch_payroll', $id)
                        ->orderby('hr_pkwt.id_kelompok_jabatan')
                        ->groupby('master_pegawai.id')
                        ->get();

        $today = date('Y-m-d');
        $getAnak = HrPkwt::join('pr_batch_payroll_detail', 'pr_batch_payroll_detail.id_pegawai', '=', 'hr_pkwt.id_pegawai')
                        ->join('master_pegawai', 'master_pegawai.id', '=', 'hr_pkwt.id_kelompok_jabatan')
                        ->select('pr_batch_payroll_detail.id_pegawai', 'hr_pkwt.id_kelompok_jabatan')
                        ->where('pr_batch_payroll_detail.id_batch_payroll', $id)
                        ->where('hr_pkwt.tanggal_awal_pkwt', '<', $today)
                        ->where('hr_pkwt.tanggal_akhir_pkwt', '>', $today)
                        ->orderby('hr_pkwt.id_kelompok_jabatan')
                        ->get();

        $getkomponengajinya = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

        // Get Batch Payrol
        $getbatch = PrBatchPayroll::join('pr_periode_gaji', 'pr_batch_payroll.id_periode_gaji', '=', 'pr_periode_gaji.id')
                                  ->where('pr_batch_payroll.id', $id)->first();

        // Start Query Detail Gaji Karyawan
        $query1 = "SELECT pegawai.id, pegawai.nip, pegawai.nama as nama_pegawai, IFNULL(tabel_Workday.workday, 0) as Jumlah_Workday, IFNULL(tabel_Jabatan.nama_jabatan, 0) as Jabatan";
        $query2 = "FROM (select a.id, a.nip, a.nama from master_pegawai a, pr_batch_payroll_detail where a.id = pr_batch_payroll_detail.id_pegawai and pr_batch_payroll_detail.id_batch_payroll = $id) as pegawai ";
        $query3 = "LEFT OUTER JOIN (SELECT d.id, d.nama, c.workday as workday FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id GROUP BY d.id) as tabel_Workday ON pegawai.id = tabel_Workday.id ";
        $query4 = "LEFT OUTER JOIN(SELECT b.nama_jabatan, a.id FROM master_pegawai a, master_jabatan b WHERE a.id_jabatan = b.id) as tabel_Jabatan ON pegawai.id = tabel_Jabatan.id";
        foreach ($getkomponengajinya as $komponen) {
          $replace = str_replace(' ', '_', $komponen->nama_komponen);
          $query1 .=  ",IFNULL(tabel_$replace.nilai, 0) as Jumlah_$replace ";
          $query2 .= "LEFT OUTER JOIN (SELECT d.id, d.nama, b.nilai as nilai FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id AND a.id = $komponen->id GROUP BY d.id) as tabel_$replace ON pegawai.id = tabel_$replace.id ";
        }
        // End Query Detail Gaji Karyawan

        $getkomponengaji = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

        $hasilQuery = DB::select($query1.$query2.$query3.$query4);
        $hasilQuery = collect($hasilQuery);

        if($hasilQuery->isEmpty()){
          return redirect()->route('batchpayroll.detail', ['id' => $id])->with('gagal', 'Tidak ada data');
        }

        Excel::create('Proses Payroll SPV Periode -'.$getbatch->tanggal_proses.' s-d '.$getbatch->tanggal_proses_akhir, function($excel) use($getSPV,$getAnak,$getkomponengaji,$getbatch,$hasilQuery) {
          foreach ($getSPV as $spv) {
            $excel->sheet($spv->nama, function($sheet) use($spv,$getAnak,$getkomponengaji,$getbatch,$hasilQuery) {
              $sheet->loadView('pages.laporanPayroll.spv')
                      ->with('getkomponengaji', $getkomponengaji)
                      ->with('getSPV', $spv->id_kelompok_jabatan)
                      ->with('getAnak', $getAnak)
                      ->with('getbatch', $getbatch)
                      ->with('hasilQuery', $hasilQuery);
            });
          }
        })->download('xlsx');

        return response()->json(['success' => 200]);

    }

    public function prosesAll($id)
    {

      $getCabangClient = DB::select("SELECT a.id, a.nama_cabang, e.nama_client
                                      FROM master_client_cabang a, hr_pkwt b, pr_batch_payroll_detail c, master_pegawai d, master_client e
                                      WHERE a.id = b.id_cabang_client
                                      AND c.id_pegawai = d.id
                                      AND b.id_pegawai = c.id_pegawai
                                      AND a.id_client = e.id
                                      AND c.id_batch_payroll = $id
                                      GROUP BY a.nama_cabang");

      $getCabangClient = collect($getCabangClient);

      $getkomponengajinya = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

      // Get Batch Payrol
      $getbatch = PrBatchPayroll::join('pr_periode_gaji', 'pr_batch_payroll.id_periode_gaji', '=', 'pr_periode_gaji.id')
                                ->where('pr_batch_payroll.id', $id)->first();

      // Start Query Detail Gaji Karyawan
      $query1 = "SELECT pegawai.id, pegawai.nip, pegawai.nama as nama_pegawai, IFNULL(tabel_Workday.workday, 0) as Jumlah_Workday, IFNULL(tabel_Jabatan.nama_jabatan, 0) as Jabatan, IFNULL(tabel_Cabang.id_cabang, 0) as Cabang ";
      $query2 = "FROM (select a.id, a.nip, a.nama from master_pegawai a, pr_batch_payroll_detail where a.id = pr_batch_payroll_detail.id_pegawai and pr_batch_payroll_detail.id_batch_payroll = $id) as pegawai ";
      $query3 = "LEFT OUTER JOIN (SELECT d.id, d.nama, c.workday as workday FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id GROUP BY d.id) as tabel_Workday ON pegawai.id = tabel_Workday.id ";
      $query4 = "LEFT OUTER JOIN(SELECT b.nama_jabatan, a.id FROM master_pegawai a, master_jabatan b WHERE a.id_jabatan = b.id) as tabel_Jabatan ON pegawai.id = tabel_Jabatan.id ";
      $query5 = "LEFT OUTER JOIN(SELECT a.id as id_cabang, c.id_pegawai as id_pegawai FROM master_client_cabang a, hr_pkwt b, pr_batch_payroll_detail c WHERE a.id = b.id_cabang_client AND b.id_pegawai = c.id_pegawai AND c.id_batch_payroll = $id AND b.status_pkwt = 1 GROUP BY b.id_pegawai) as tabel_Cabang ON pegawai.id = tabel_Cabang.id_pegawai ";
      foreach ($getkomponengajinya as $komponen) {
        $replace = str_replace(' ', '_', $komponen->nama_komponen);
        $query1 .=  ",IFNULL(tabel_$replace.nilai, 0) as Jumlah_$replace ";
        $query2 .= "LEFT OUTER JOIN (SELECT d.id, d.nama, b.nilai as nilai FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id AND a.id = $komponen->id GROUP BY d.id) as tabel_$replace ON pegawai.id = tabel_$replace.id ";
      }
      // End Query Detail Gaji Karyawan

      $getkomponengaji = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

      $hasilQuery = DB::select($query1.$query2.$query3.$query4.$query5);
      $hasilQuery = collect($hasilQuery);

      $totalkerjabulan = DB::select("SELECT id_pegawai, workday, SUM(workday - (abstain+sick_leave+permissed_leave)) as jumlah_kerja
                                    FROM pr_batch_payroll_detail
                                    WHERE id_batch_payroll = '$id'
                                    GROUP BY id_pegawai");
      $totalkerjabulan = collect($totalkerjabulan);

      Excel::create('Proses Payroll Periode -'.$getbatch->tanggal_proses.' s-d '.$getbatch->tanggal_proses_akhir, function($excel) use($getkomponengaji,$getbatch,$hasilQuery,$totalkerjabulan,$getCabangClient) {
          $excel->sheet('All Payroll', function($sheet) use($getkomponengaji,$getbatch,$hasilQuery,$totalkerjabulan,$getCabangClient) {
            $sheet->loadView('pages.laporanPayroll.allProses')
                    ->with('getkomponengaji', $getkomponengaji)
                    ->with('getbatch', $getbatch)
                    ->with('getCabangClient', $getCabangClient)
                    ->with('hasilQuery', $hasilQuery)
                    ->with('totalkerjabulan', $totalkerjabulan);
          });
      })->download('xlsx');

      return response()->json(['success' => 200]);

    }

    public function prosesBank($id)
    {
      // Get Batch Payrol
      $getbatch = PrBatchPayroll::join('pr_periode_gaji', 'pr_batch_payroll.id_periode_gaji', '=', 'pr_periode_gaji.id')
                                ->where('pr_batch_payroll.id', $id)->first();

      $getkomponengajinya = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

      $getbank = MasterBank::get();

      if($getbank->isEmpty()){
        return redirect()->route('batchpayroll.detail', array('id' => $id))->with('gagal', 'Harap Mengisi Data Bank Pada Master Bank dan Pegawai');
      }

      // Start Query Detail Gaji Karyawan
      $query1 = "SELECT pegawai.id, pegawai.nip, pegawai.nama as nama_pegawai, pegawai.no_rekening, pegawai.id_bank, IFNULL(tabel_Workday.workday, 0) as Jumlah_Workday, IFNULL(tabel_Jabatan.nama_jabatan, 0) as Jabatan ";
      $query2 = "FROM (select a.id, a.nip, a.nama, a.no_rekening, a.id_bank from master_pegawai a, pr_batch_payroll_detail where a.id = pr_batch_payroll_detail.id_pegawai and pr_batch_payroll_detail.tipe_pembayaran = 1 and pr_batch_payroll_detail.id_batch_payroll = $id) as pegawai ";
      $query3 = "LEFT OUTER JOIN (SELECT d.id, d.nama, c.workday as workday FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id GROUP BY d.id) as tabel_Workday ON pegawai.id = tabel_Workday.id ";
      $query4 = "LEFT OUTER JOIN(SELECT b.nama_jabatan, a.id FROM master_pegawai a, master_jabatan b WHERE a.id_jabatan = b.id) as tabel_Jabatan ON pegawai.id = tabel_Jabatan.id ";
      foreach ($getkomponengajinya as $komponen) {
        $replace = str_replace(' ', '_', $komponen->nama_komponen);
        $query1 .=  ",IFNULL(tabel_$replace.nilai, 0) as Jumlah_$replace ";
        $query2 .= "LEFT OUTER JOIN (SELECT d.id, d.nama, b.nilai as nilai FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id AND a.id = $komponen->id GROUP BY d.id) as tabel_$replace ON pegawai.id = tabel_$replace.id ";
      }
      // End Query Detail Gaji Karyawan

      $getkomponengaji = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

      $hasilQuery = DB::select($query1.$query2.$query3.$query4);
      $hasilQuery = collect($hasilQuery);

      $totalkerjabulan = DB::select("SELECT id_pegawai, workday, SUM(workday - (abstain+sick_leave+permissed_leave)) as jumlah_kerja
                                    FROM pr_batch_payroll_detail
                                    WHERE id_batch_payroll = '$id'
                                    GROUP BY id_pegawai");
      $totalkerjabulan = collect($totalkerjabulan);

      $nilaiTransfer = array();
      foreach($hasilQuery as $key)
      {
        foreach ($totalkerjabulan as $totalkerja){
          if ($totalkerja->id_pegawai == $key->id){
            $hasilgajihari = $key->Jumlah_GAJI_POKOK / $totalkerja->workday;
            $hasilgajihari = $hasilgajihari;
            $dapatgaji = $hasilgajihari * $totalkerja->jumlah_kerja;
          }
        }

        foreach ($totalkerjabulan as $totalkerja){
          if ($totalkerja->id_pegawai == $key->id){
              $transportmakan = $totalkerja->jumlah_kerja * $key->Jumlah_TUNJANGAN_TRANSPORT_MAKAN;
          }
        }

        $jumlahGajinya = $dapatgaji + $key->Jumlah_TUNJANGAN_JABATAN + $key->Jumlah_TUNJANGAN_INSENTIF + $key->Jumlah_TUNJANGAN_LEMBUR + $key->Jumlah_KEKURANGAN_BULAN_LALU + $transportmakan + $key->Jumlah_KETUA_REGU + $key->Jumlah_PENGEMBALIAN_SERAGAM + $key->Jumlah_TUNJANGAN_MAKAN_LEMBUR + $key->Jumlah_SALARY + $key->Jumlah_SHIFT_PAGI_SIANG + $key->Jumlah_TUNJANGAN_MAKAN_TRANSPORT;

        $jumlahPotongannya = $key->Jumlah_BPJS_KESEHATAN + $key->Jumlah_POTONGAN_KAS + $key->Jumlah_BPJS_KETENAGAKERJAAN + $key->Jumlah_POTONGAN_PINJAMAN + $key->Jumlah_POTONGAN_SERAGAM + $key->Jumlah_POTONGAN_CONSUMABLE + $key->Jumlah_BPJS_PENSIUN;

        $grandTotalGaji = $jumlahGajinya - $jumlahPotongannya;

        $Transfer['id'] = $key->id;
        $Transfer['nip'] = $key->nip;
        $Transfer['nama_pegawai'] = $key->nama_pegawai;
        $Transfer['id_bank'] = $key->id_bank;
        $Transfer['no_rekening'] = $key->no_rekening;
        $Transfer['grandTotalGaji'] = $grandTotalGaji;

        $nilaiTransfer[] = $Transfer;
      }


      $nilaiTransfer = collect($nilaiTransfer);

      Excel::create('Proses Payroll Transfer Bank Periode -'.$getbatch->tanggal_proses.' s-d '.$getbatch->tanggal_proses_akhir, function($excel) use($getbank,$getbatch,$nilaiTransfer) {
        foreach ($getbank as $bank) {
          $excel->sheet("Salary Transfer - ".$bank->nama_bank, function($sheet) use($bank,$getbatch,$nilaiTransfer) {
            $sheet->loadView('pages.laporanPayroll.bankProses')
                    ->with('id_bank', $bank->id)
                    ->with('nama_bank', $bank->nama_bank)
                    ->with('getbatch', $getbatch)
                    ->with('nilaiTransfer', $nilaiTransfer);
          });
        }
      })->download('xlsx');

      return response()->json(['success' => 200]);
    }

    public function prosesCash($id)
    {
      // Get Batch Payrol
      $getbatch = PrBatchPayroll::join('pr_periode_gaji', 'pr_batch_payroll.id_periode_gaji', '=', 'pr_periode_gaji.id')
                                ->where('pr_batch_payroll.id', $id)->first();

      $getkomponengajinya = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

      // Start Query Detail Gaji Karyawan
      $query1 = "SELECT pegawai.id, pegawai.nip, pegawai.nama as nama_pegawai, pegawai.no_rekening, pegawai.id_bank, pegawai.tipe_pembayaran, IFNULL(tabel_Workday.workday, 0) as Jumlah_Workday, IFNULL(tabel_Jabatan.nama_jabatan, 0) as Jabatan ";
      $query2 = "FROM (select a.id, a.nip, a.nama, a.no_rekening, a.id_bank, pr_batch_payroll_detail.tipe_pembayaran from master_pegawai a, pr_batch_payroll_detail where a.id = pr_batch_payroll_detail.id_pegawai and pr_batch_payroll_detail.id_batch_payroll = $id) as pegawai ";
      $query3 = "LEFT OUTER JOIN (SELECT d.id, d.nama, c.workday as workday FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id GROUP BY d.id) as tabel_Workday ON pegawai.id = tabel_Workday.id ";
      $query4 = "LEFT OUTER JOIN(SELECT b.nama_jabatan, a.id FROM master_pegawai a, master_jabatan b WHERE a.id_jabatan = b.id) as tabel_Jabatan ON pegawai.id = tabel_Jabatan.id ";
      foreach ($getkomponengajinya as $komponen) {
        $replace = str_replace(' ', '_', $komponen->nama_komponen);
        $query1 .=  ",IFNULL(tabel_$replace.nilai, 0) as Jumlah_$replace ";
        $query2 .= "LEFT OUTER JOIN (SELECT d.id, d.nama, b.nilai as nilai FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id AND a.id = $komponen->id GROUP BY d.id) as tabel_$replace ON pegawai.id = tabel_$replace.id ";
      }
      // End Query Detail Gaji Karyawan

      $getkomponengaji = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

      $hasilQuery = DB::select($query1.$query2.$query3.$query4);
      $hasilQuery = collect($hasilQuery);

      $totalkerjabulan = DB::select("SELECT id_pegawai, workday, SUM(workday - (abstain+sick_leave+permissed_leave)) as jumlah_kerja
                                    FROM pr_batch_payroll_detail
                                    WHERE id_batch_payroll = '$id'
                                    GROUP BY id_pegawai");
      $totalkerjabulan = collect($totalkerjabulan);

      $nilaiTransfer = array();
      foreach($hasilQuery as $key)
      {
        if($key->id_bank == null || $key->tipe_pembayaran == 0){
          foreach ($totalkerjabulan as $totalkerja){
            if ($totalkerja->id_pegawai == $key->id){
              $hasilgajihari = $key->Jumlah_GAJI_POKOK / $totalkerja->workday;
              $hasilgajihari = $hasilgajihari;
              $dapatgaji = $hasilgajihari * $totalkerja->jumlah_kerja;
            }
          }

          foreach ($totalkerjabulan as $totalkerja){
            if ($totalkerja->id_pegawai == $key->id){
                $transportmakan = $totalkerja->jumlah_kerja * $key->Jumlah_TUNJANGAN_TRANSPORT_MAKAN;
            }
          }

          $jumlahGajinya = $dapatgaji + $key->Jumlah_TUNJANGAN_JABATAN + $key->Jumlah_TUNJANGAN_INSENTIF + $key->Jumlah_TUNJANGAN_LEMBUR + $key->Jumlah_KEKURANGAN_BULAN_LALU + $transportmakan + $key->Jumlah_KETUA_REGU + $key->Jumlah_PENGEMBALIAN_SERAGAM + $key->Jumlah_TUNJANGAN_MAKAN_LEMBUR + $key->Jumlah_SALARY + $key->Jumlah_SHIFT_PAGI_SIANG + $key->Jumlah_TUNJANGAN_MAKAN_TRANSPORT;

          $jumlahPotongannya = $key->Jumlah_BPJS_KESEHATAN + $key->Jumlah_POTONGAN_KAS + $key->Jumlah_BPJS_KETENAGAKERJAAN + $key->Jumlah_POTONGAN_PINJAMAN + $key->Jumlah_POTONGAN_SERAGAM + $key->Jumlah_POTONGAN_CONSUMABLE + $key->Jumlah_BPJS_PENSIUN;

          $grandTotalGaji = $jumlahGajinya - $jumlahPotongannya;

          $Transfer['id'] = $key->id;
          $Transfer['nip'] = $key->nip;
          $Transfer['nama_pegawai'] = $key->nama_pegawai;
          $Transfer['id_bank'] = $key->id_bank;
          $Transfer['no_rekening'] = $key->no_rekening;
          $Transfer['grandTotalGaji'] = $grandTotalGaji;

          $nilaiTransfer[] = $Transfer;
        }
      }


      $nilaiTransfer = collect($nilaiTransfer);

      Excel::create('Proses Payroll Cash Periode -'.$getbatch->tanggal_proses.' s-d '.$getbatch->tanggal_proses_akhir, function($excel) use($getbatch,$nilaiTransfer) {
        $excel->sheet("Salary Cash - ", function($sheet) use($getbatch,$nilaiTransfer) {
          $sheet->loadView('pages.laporanPayroll.cashProses')
                  ->with('getbatch', $getbatch)
                  ->with('nilaiTransfer', $nilaiTransfer);
        });
      })->download('xlsx');

      return response()->json(['success' => 200]);
    }


    public function prosesClient($id)
    {
        $getCabangClient = DB::select("SELECT a.id, a.nama_cabang
                                        FROM master_client_cabang a, hr_pkwt b, pr_batch_payroll_detail c, master_pegawai d
                                        WHERE a.id = b.id_cabang_client
                                        AND c.id_pegawai = d.id
                                        AND b.id_pegawai = c.id_pegawai
                                        AND c.id_batch_payroll = $id
                                        GROUP BY a.nama_cabang");
        $getCabangClient = collect($getCabangClient);

        $getkomponengajinya = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

        // Get Batch Payrol
        $getbatch = PrBatchPayroll::join('pr_periode_gaji', 'pr_batch_payroll.id_periode_gaji', '=', 'pr_periode_gaji.id')
                                  ->where('pr_batch_payroll.id', $id)->first();

        // Start Query Detail Gaji Karyawan
        $query1 = "SELECT pegawai.id, pegawai.nip, pegawai.nama as nama_pegawai, IFNULL(tabel_Workday.workday, 0) as Jumlah_Workday, IFNULL(tabel_Jabatan.nama_jabatan, 0) as Jabatan, IFNULL(tabel_Cabang.id_cabang, 0) as Cabang ";
        $query2 = "FROM (select a.id, a.nip, a.nama from master_pegawai a, pr_batch_payroll_detail where a.id = pr_batch_payroll_detail.id_pegawai and pr_batch_payroll_detail.id_batch_payroll = $id) as pegawai ";
        $query3 = "LEFT OUTER JOIN (SELECT d.id, d.nama, c.workday as workday FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id GROUP BY d.id) as tabel_Workday ON pegawai.id = tabel_Workday.id ";
        $query4 = "LEFT OUTER JOIN(SELECT b.nama_jabatan, a.id FROM master_pegawai a, master_jabatan b WHERE a.id_jabatan = b.id) as tabel_Jabatan ON pegawai.id = tabel_Jabatan.id ";
        $query5 = "LEFT OUTER JOIN(SELECT a.id as id_cabang, c.id_pegawai as id_pegawai FROM master_client_cabang a, hr_pkwt b, pr_batch_payroll_detail c WHERE a.id = b.id_cabang_client AND b.id_pegawai = c.id_pegawai AND c.id_batch_payroll = $id AND b.status_pkwt = 1 GROUP BY b.id_pegawai) as tabel_Cabang ON pegawai.id = tabel_Cabang.id_pegawai ";
        foreach ($getkomponengajinya as $komponen) {
          $replace = str_replace(' ', '_', $komponen->nama_komponen);
          $query1 .=  ",IFNULL(tabel_$replace.nilai, 0) as Jumlah_$replace ";
          $query2 .= "LEFT OUTER JOIN (SELECT d.id, d.nama, b.nilai as nilai FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id AND a.id = $komponen->id GROUP BY d.id) as tabel_$replace ON pegawai.id = tabel_$replace.id ";
        }
        // End Query Detail Gaji Karyawan

        $getkomponengaji = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

        $hasilQuery = DB::select($query1.$query2.$query3.$query4.$query5);
        $hasilQuery = collect($hasilQuery);

        $totalkerjabulan = DB::select("SELECT id_pegawai, workday, SUM(workday - (abstain+sick_leave+permissed_leave)) as jumlah_kerja
                                      FROM pr_batch_payroll_detail
                                      WHERE id_batch_payroll = '$id'
                                      GROUP BY id_pegawai");
        $totalkerjabulan = collect($totalkerjabulan);

        $nilaiClient = array();
        foreach ($getCabangClient as $client)
        {
          $no = 1;
          $grandJumlahGaji = 0;
          $grandTotalGaji = 0;
          $JumlahGaji = 0;
          $TotalGaji = 0;
          $Jumlah_Workday = 0;
          $Jumlah_GAJI_POKOK = 0;
          $Jumlah_TUNJANGAN_JABATAN = 0;
          $Jumlah_TUNJANGAN_INSENTIF = 0;
          $Jumlah_TUNJANGAN_LEMBUR = 0;
          $Jumlah_KEKURANGAN_BULAN_LALU = 0;
          $Jumlah_TUNJANGAN_TRANSPORT_MAKAN = 0;
          $Jumlah_KETUA_REGU = 0;
          $Jumlah_PENGEMBALIAN_SERAGAM = 0;
          $Jumlah_TUNJANGAN_MAKAN_LEMBUR = 0;
          $Jumlah_SALARY = 0;
          $Jumlah_SHIFT_PAGI_SIANG = 0;
          $Jumlah_TUNJANGAN_MAKAN_TRANSPORT = 0;
          $Jumlah_POTONGAN_KAS = 0;
          $Jumlah_BPJS_KESEHATAN = 0;
          $Jumlah_BPJS_KETENAGAKERJAAN = 0;
          $Jumlah_BPJS_PENSIUN = 0;
          $Jumlah_POTONGAN_PINJAMAN = 0;
          $Jumlah_POTONGAN_SERAGAM = 0;
          $Jumlah_POTONGAN_CONSUMABLE = 0;

          $Client['client'] = $client->nama_cabang;

          foreach($hasilQuery as $key)
          {
            if($key->Cabang == $client->id)
            {
              foreach ($totalkerjabulan as $totalkerja){
                if ($totalkerja->id_pegawai == $key->id){
                  $hasilgajihari = $key->Jumlah_GAJI_POKOK / $totalkerja->workday;
                  $hasilgajihari = $hasilgajihari;
                  $dapatgaji = $hasilgajihari * $totalkerja->jumlah_kerja;
                }
              }

              foreach ($totalkerjabulan as $totalkerja){
                if ($totalkerja->id_pegawai == $key->id){
                    $transportmakan = floor($totalkerja->jumlah_kerja * $key->Jumlah_TUNJANGAN_TRANSPORT_MAKAN);
                }
              }

              $Jumlah_Workday += $key->Jumlah_Workday;
              $Jumlah_GAJI_POKOK += $dapatgaji;
              $Jumlah_TUNJANGAN_JABATAN += $key->Jumlah_TUNJANGAN_JABATAN;
              $Jumlah_TUNJANGAN_INSENTIF += $key->Jumlah_TUNJANGAN_INSENTIF;
              $Jumlah_TUNJANGAN_LEMBUR += $key->Jumlah_TUNJANGAN_LEMBUR;
              $Jumlah_KEKURANGAN_BULAN_LALU += $key->Jumlah_KEKURANGAN_BULAN_LALU;
              $Jumlah_TUNJANGAN_TRANSPORT_MAKAN += $transportmakan;
              $Jumlah_KETUA_REGU += $key->Jumlah_KETUA_REGU;
              $Jumlah_PENGEMBALIAN_SERAGAM += $key->Jumlah_PENGEMBALIAN_SERAGAM;
              $Jumlah_TUNJANGAN_MAKAN_LEMBUR += $key->Jumlah_TUNJANGAN_MAKAN_LEMBUR;
              $Jumlah_SALARY += $key->Jumlah_SALARY;
              $Jumlah_SHIFT_PAGI_SIANG += $key->Jumlah_SHIFT_PAGI_SIANG;
              $Jumlah_TUNJANGAN_MAKAN_TRANSPORT += $key->Jumlah_TUNJANGAN_MAKAN_TRANSPORT;

              $jumlahGajinya = $dapatgaji + $key->Jumlah_TUNJANGAN_JABATAN + $key->Jumlah_TUNJANGAN_INSENTIF + $key->Jumlah_TUNJANGAN_LEMBUR + $key->Jumlah_KEKURANGAN_BULAN_LALU + $transportmakan + $key->Jumlah_KETUA_REGU + $key->Jumlah_PENGEMBALIAN_SERAGAM + $key->Jumlah_TUNJANGAN_MAKAN_LEMBUR + $key->Jumlah_SALARY + $key->Jumlah_SHIFT_PAGI_SIANG + $key->Jumlah_TUNJANGAN_MAKAN_TRANSPORT;

              $grandJumlahGaji += $jumlahGajinya;

              $Jumlah_BPJS_KESEHATAN += $key->Jumlah_BPJS_KESEHATAN;
              $Jumlah_POTONGAN_KAS += $key->Jumlah_POTONGAN_KAS;
              $Jumlah_BPJS_KETENAGAKERJAAN += $key->Jumlah_BPJS_KETENAGAKERJAAN;
              $Jumlah_BPJS_PENSIUN += $key->Jumlah_BPJS_PENSIUN;
              $Jumlah_POTONGAN_PINJAMAN += $key->Jumlah_POTONGAN_PINJAMAN;
              $Jumlah_POTONGAN_SERAGAM += $key->Jumlah_POTONGAN_SERAGAM;
              $Jumlah_POTONGAN_CONSUMABLE += $key->Jumlah_POTONGAN_CONSUMABLE;

              $jumlahPotongannya = $key->Jumlah_BPJS_KESEHATAN + $key->Jumlah_POTONGAN_KAS + $key->Jumlah_BPJS_KETENAGAKERJAAN + $key->Jumlah_POTONGAN_PINJAMAN + $key->Jumlah_POTONGAN_SERAGAM + $key->Jumlah_POTONGAN_CONSUMABLE + $key->Jumlah_BPJS_PENSIUN;

              $grandTotalGaji += $jumlahGajinya - $jumlahPotongannya;
              // dd($jumlahGajinya, $jumlahPotongannya, $grandTotalGaji);
            }
          }

          $Client['grandTotalGaji'] = $grandTotalGaji;

          $nilaiClient[] = $Client;
        }

        $nilaiClient = collect($nilaiClient);

        Excel::create('Rekap Payroll Periode -'.$getbatch->tanggal_proses.' s-d '.$getbatch->tanggal_proses_akhir, function($excel) use($nilaiClient,$getbatch,$getCabangClient) {
            $excel->sheet('Payroll Client', function($sheet) use($nilaiClient,$getCabangClient,$getbatch) {
              $sheet->loadView('pages.laporanPayroll.clientProses')
                      ->with('nilaiClient', $nilaiClient)
                      ->with('getbatch', $getbatch)
                      ->with('getCabangClient', $getCabangClient);
            });
        })->download('xlsx');

        return response()->json(['success' => 200]);

    }

    public function prosesSlipGaji($id)
    {

        $getCabangClient = DB::select("SELECT a.id, a.nama_cabang, e.nama_client
                                      FROM master_client_cabang a, hr_pkwt b, pr_batch_payroll_detail c, master_pegawai d, master_client e
                                      WHERE a.id = b.id_cabang_client
                                      AND c.id_pegawai = d.id
                                      AND b.id_pegawai = c.id_pegawai
                                      AND a.id_client = e.id
                                      AND c.id_batch_payroll = $id
                                      GROUP BY a.nama_cabang");

        $getCabangClient = collect($getCabangClient);

        $getkomponengajinya = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

        $getbank = MasterBank::get();

        // Get Batch Payrol
        $getbatch = PrBatchPayroll::join('pr_periode_gaji', 'pr_batch_payroll.id_periode_gaji', '=', 'pr_periode_gaji.id')
                                  ->where('pr_batch_payroll.id', $id)->first();

        // Start Query Detail Gaji Karyawan
        $query1 = "SELECT pegawai.id, pegawai.nip, pegawai.nama as nama_pegawai, pegawai.no_rekening, pegawai.id_bank, pegawai.tipe_pembayaran, IFNULL(tabel_Workday.workday, 0) as Jumlah_Workday, IFNULL(tabel_Jabatan.nama_jabatan, 0) as Jabatan, IFNULL(tabel_Cabang.id_cabang, 0) as Cabang ";
        $query2 = "FROM (select a.id, a.nip, a.nama, a.no_rekening, a.id_bank, pr_batch_payroll_detail.tipe_pembayaran from master_pegawai a, pr_batch_payroll_detail where a.id = pr_batch_payroll_detail.id_pegawai and pr_batch_payroll_detail.id_batch_payroll = $id) as pegawai ";
        $query3 = "LEFT OUTER JOIN (SELECT d.id, d.nama, c.workday as workday FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id GROUP BY d.id) as tabel_Workday ON pegawai.id = tabel_Workday.id ";
        $query4 = "LEFT OUTER JOIN(SELECT b.nama_jabatan, a.id FROM master_pegawai a, master_jabatan b WHERE a.id_jabatan = b.id) as tabel_Jabatan ON pegawai.id = tabel_Jabatan.id ";
        $query5 = "LEFT OUTER JOIN(SELECT a.id as id_cabang, c.id_pegawai as id_pegawai FROM master_client_cabang a, hr_pkwt b, pr_batch_payroll_detail c WHERE a.id = b.id_cabang_client AND b.id_pegawai = c.id_pegawai AND c.id_batch_payroll = $id AND b.status_pkwt = 1 GROUP BY b.id_pegawai) as tabel_Cabang ON pegawai.id = tabel_Cabang.id_pegawai ";
        foreach ($getkomponengajinya as $komponen) {
          $replace = str_replace(' ', '_', $komponen->nama_komponen);
          $query1 .=  ",IFNULL(tabel_$replace.nilai, 0) as $replace ";
          $query2 .= "LEFT OUTER JOIN (SELECT d.id, d.nama, b.nilai as nilai FROM master_komponen_gaji a, pr_komponen_gaji_detail b, pr_batch_payroll_detail c, master_pegawai d WHERE b.id_komponen_gaji = a.id AND b.id_batch_payroll_detail = c.id AND d.id = c.id_pegawai AND c.id_batch_payroll = $id AND a.id = $komponen->id GROUP BY d.id) as tabel_$replace ON pegawai.id = tabel_$replace.id ";
        }
        // End Query Detail Gaji Karyawan

        $getkomponengaji = MasterKomponenGaji::orderby('tipe_komponen', 'asc')->get();

        $hasilQuery = DB::select($query1.$query2.$query3.$query4.$query5);
        // $hasilQuery = collect($hasilQuery);

        $hasilQuery = array_map(function ($value) {
                    return (array)$value;
                }, $hasilQuery);

        $totalkerjabulan = DB::select("SELECT id_pegawai, workday, SUM(workday - (abstain+sick_leave+permissed_leave)) as jumlah_kerja
                                      FROM pr_batch_payroll_detail
                                      WHERE id_batch_payroll = '$id'
                                      GROUP BY id_pegawai");
        $totalkerjabulan = collect($totalkerjabulan);


        // dd($hasilQuery,$getkomponengajinya,$totalkerjabulan,$getCabangClient);

        foreach ($hasilQuery as $payroll)
        {
          $slipPegawai = array();
          $slipPegawai["tanggal_proses"] = $getbatch->tanggal_proses;
          $slipPegawai["tanggal_proses_akhir"] = $getbatch->tanggal_proses_akhir;
          $slipPegawai["nama_pegawai"] = $payroll["nama_pegawai"];
          $slipPegawai["jabatan"] = $payroll["Jabatan"];
          $slipPegawai["no_rekening"] = $payroll["no_rekening"];
          $slipPegawai["tipe_pembayaran"] = $payroll["tipe_pembayaran"];

          foreach ($getCabangClient as $cabangClient)
          {
            if($cabangClient->id == $payroll["Cabang"])
            $slipPegawai["client"] =  $cabangClient->nama_client;
            $slipPegawai["cabang"] =  $cabangClient->nama_cabang;
          }

          foreach ($totalkerjabulan as $harikerja)
          {
            if($harikerja->id_pegawai == $payroll["id"])
            {
              $slipPegawai["hari_kerja"] = $harikerja->jumlah_kerja.'/'.$harikerja->workday;
            }
          }

          $slipPegawai["penerimaan"] = array();
          foreach ($getkomponengajinya as $terima)
          {
            if($terima->tipe_komponen == "D")
            {
              if(str_replace(' ', '_', $terima->nama_komponen) == 'GAJI_POKOK')
              {
                $slipPegawai["penerimaan"]["gaji_pokok"] = $payroll["GAJI_POKOK"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'TUNJANGAN_JABATAN')
              {
                $slipPegawai["penerimaan"]["tunjangan_jabatan"] = $payroll["TUNJANGAN_JABATAN"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'TUNJANGAN_INSENTIF')
              {
                $slipPegawai["penerimaan"]["tunjangan_insentif"] = $payroll["TUNJANGAN_INSENTIF"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'TUNJANGAN_LEMBUR')
              {
                $slipPegawai["penerimaan"]["tunjangan_lembur"] = $payroll["TUNJANGAN_LEMBUR"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'KEKURANGAN_BULAN_LALU')
              {
                $slipPegawai["penerimaan"]["kekurangan_bulan_lalu"] = $payroll["KEKURANGAN_BULAN_LALU"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'TUNJANGAN_TRANSPORT_MAKAN')
              {
                $slipPegawai["penerimaan"]["tunjangan_transport_makan"] = $payroll["TUNJANGAN_TRANSPORT_MAKAN"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'KETUA_REGU')
              {
                $slipPegawai["penerimaan"]["ketua_regu"] = $payroll["KETUA_REGU"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'PENGEMBALIAN_SERAGAM')
              {
                $slipPegawai["penerimaan"]["pengembalian_seragam"] = $payroll["PENGEMBALIAN_SERAGAM"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'TUNJANGAN_MAKAN_LEMBUR')
              {
                $slipPegawai["penerimaan"]["tunjangan_makan_lembur"] = $payroll["TUNJANGAN_MAKAN_LEMBUR"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'SALARY')
              {
                $slipPegawai["penerimaan"]["salary"] = $payroll["SALARY"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'SHIFT_PAGI_SIANG')
              {
                $slipPegawai["penerimaan"]["shift_pagi_siang"] = $payroll["SHIFT_PAGI_SIANG"];
              }
              if(str_replace(' ', '_', $terima->nama_komponen) == 'TUNJANGAN_MAKAN_TRANSPORT')
              {
                $slipPegawai["penerimaan"]["tunjangan_makan_transport"] = $payroll["TUNJANGAN_MAKAN_TRANSPORT"];
              }
            }
          }

          $slipPegawai["potongan"] = array();
          foreach ($getkomponengajinya as $potong)
          {
            if($potong->tipe_komponen == "P")
            {
              if(str_replace(' ', '_', $potong->nama_komponen) == 'BPJS_KESEHATAN')
              {
                $slipPegawai["potongan"]["bpjs_kesehatan"] = $payroll["BPJS_KESEHATAN"];
              }
              if(str_replace(' ', '_', $potong->nama_komponen) == 'BPJS_KETENAGAKERJAAN')
              {
                $slipPegawai["potongan"]["bpjs_ketenagakerjaan"] = $payroll["BPJS_KETENAGAKERJAAN"];
              }
              if(str_replace(' ', '_', $potong->nama_komponen) == 'BPJS_PENSIUN')
              {
                $slipPegawai["potongan"]["bpjs_pensiun"] = $payroll["BPJS_PENSIUN"];
              }
              if(str_replace(' ', '_', $potong->nama_komponen) == 'POTONGAN_KAS')
              {
                $slipPegawai["potongan"]["potongan_kas"] = $payroll["POTONGAN_KAS"];
              }
              if(str_replace(' ', '_', $potong->nama_komponen) == 'POTONGAN_PINJAMAN')
              {
                $slipPegawai["potongan"]["potongan_pinjaman"] = $payroll["POTONGAN_PINJAMAN"];
              }
              if(str_replace(' ', '_', $potong->nama_komponen) == 'POTONGAN_SERAGAM')
              {
                $slipPegawai["potongan"]["potongan_seragam"] = $payroll["POTONGAN_SERAGAM"];
              }
              if(str_replace(' ', '_', $potong->nama_komponen) == 'POTONGAN_CONSUMABLE')
              {
                $slipPegawai["potongan"]["potongan_consumable"] = $payroll["POTONGAN_CONSUMABLE"];
              }
            }
          }

          foreach ($getbank as $bank)
          {
            if($bank->id == $payroll["id_bank"])
            {
              $slipPegawai["bank"] = $bank->nama_bank;
            }
          }

        $rekapslip[] = $slipPegawai;
        }

        // dd($rekapslip,$hasilQuery,$getkomponengajinya,$totalkerjabulan,$getCabangClient);

        return view('pages.laporanPayroll.slipGaji', compact('rekapslip'));
    }
}
