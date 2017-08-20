<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterPegawai;
use App\Models\HrPkwt;
use App\Models\PrPeriodeGaji;
use App\Models\PrBatchPayrollDetail;
use App\Models\PrPeriodeGajiDetail;
use App\Models\MasterClient;
use App\Models\MasterClientCabang;

class PegawaiToPeriodeController extends Controller
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

    public function index() {
      $periodeGaji  = PrPeriodeGaji::get();
      $getClient  = MasterClient::select('id', 'nama_client')->get();
      $getCabang = MasterClientCabang::select('id','kode_cabang','nama_cabang', 'id_client')->get();


      return view('pages.periode-gaji.setPegawai', compact('periodeGaji', 'getClient', 'getCabang'));
    }

    public function proses(Request $request)
    {
      $idCabangClient = $request->id_client;
      $periodeGaji  = PrPeriodeGaji::get();
      $getClient  = MasterClient::select('id', 'nama_client')->get();
      $getCabang = MasterClientCabang::select('id','kode_cabang','nama_cabang', 'id_client')->get();

      $pkwtActive = HrPkwt::join('master_pegawai', 'master_pegawai.id', '=', 'hr_pkwt.id_pegawai')
                        ->join('master_pegawai as spv', 'spv.id', '=', 'hr_pkwt.id_kelompok_jabatan')
                        ->join('master_client_cabang', 'master_client_cabang.id', '=', 'hr_pkwt.id_cabang_client')
                        ->join('master_client', 'master_client.id', '=', 'master_client_cabang.id_client')
                        ->join('master_jabatan', 'master_jabatan.id', '=', 'master_pegawai.id_jabatan')
                        ->leftJoin('pr_periode_gaji_detail as periode_detail', 'master_pegawai.id', '=', 'periode_detail.id_pegawai')
                        ->leftJoin('pr_periode_gaji as periode_gaji', 'periode_detail.id_periode_gaji', '=', 'periode_gaji.id')
                        ->select('hr_pkwt.*', 'master_pegawai.nama', 'master_pegawai.id as idpegawai', 'spv.nama as spv_nama', 'master_client.nama_client', 'master_client_cabang.nama_cabang', 'periode_detail.id_pegawai as periode_pegawai','periode_detail.id_periode_gaji as periode_gaji', 'periode_gaji.tanggal as tanggal_periode')
                        ->where('status_pkwt', 1)
                        ->where('master_client_cabang.id', $idCabangClient)
                        ->where('master_pegawai.status', 1)
                        ->where('flag_terminate', 1)
                        ->get();
      // dd($pkwtActive);
      return view('pages.periode-gaji.setPegawai', compact('periodeGaji','getClient', 'idCabangClient', 'pkwtActive', 'getCabang'));
    }

    public function store(Request $request)
    {
      if ($request->idpegawai != null) {
          $countfailed = 0;
          foreach ($request->idpegawai as $key) {
            $check = PrPeriodeGajiDetail::where('id_pegawai', $key)->get();

            if(count($check)==0) {
              $set = new PrPeriodeGajiDetail;
              $set->id_periode_gaji = $request->periodegaji;
              $set->id_pegawai = $key;
              $set->save();
            } else {
              $countfailed++;
            }
          }

          if ($countfailed==0) {
            return redirect()->route('periodepegawai.index')->with('message', 'Berhasil memasukkan seluruh data pegawai ke periode penggajian.');
          } else {
            return redirect()->route('periodepegawai.index')->with('message', 'Berhasil memasukkan data pegawai ke periode penggajian, namun ada beberapa pegawai yang gagal dimasukkan karena telah terdaftar dalam periode penggajian yang lainnya.');
          }
      } else {
          return redirect()->route('periodepegawai.index')->with('gagal', 'Pilih data pegawai tersebuh dahulu.');
      }
    }

    public function delete($id)
    {
      $get = PrPeriodeGajiDetail::find($id);
      $get->delete();

      return redirect()->route('periodegaji.detail', $get->id_periode_gaji)->with('message', 'Berhasil menghapus pegawai dari periode.');
    }
}
