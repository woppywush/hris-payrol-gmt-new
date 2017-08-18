<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterClient;
use App\Models\MasterClientCabang;
use App\Models\MasterPegawai;
use App\Models\PrRapelGaji;

use App\Models\PrBatchPayroll;
use App\Models\PrBatchProcessed;
use App\Models\PrRapelGajiDetail;
use App\Models\PrPeriodeGajiDetail;
use App\Models\PrHistoriGajiPokokPerClient;
use App\Models\PrHistoriGajiPokok;

use App\Models\HrPkwt;

class RapelGajiController extends Controller
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

    public function index()
    {
      $getClient  = MasterClient::select('id', 'nama_client')->get();
      $getCabang = MasterClientCabang::select('id','kode_cabang','nama_cabang', 'id_client')->get();


      return view('pages.rapelGaji.index')
        ->with('getClient', $getClient)
        ->with('getCabang', $getCabang);
    }

    public function list()
    {
      $get = PrRapelGaji::select('pr_rapel_gaji.id as id_rapel', 'master_client.nama_client', 'master_client_cabang.nama_cabang', 'pr_rapel_gaji.tanggal_proses', 'pr_histori_gaji_pokok_per_client.nilai')
        ->join('pr_histori_gaji_pokok_per_client', 'pr_rapel_gaji.id_histori', '=', 'pr_histori_gaji_pokok_per_client.id')
        ->join('master_client_cabang', 'pr_histori_gaji_pokok_per_client.id_cabang_client', '=', 'master_client_cabang.id')
        ->join('master_client', 'pr_histori_gaji_pokok_per_client.id_client', '=', 'master_client.id')
        ->get();

      return view('pages.rapelGaji.listrapelgaji')->with('data', $get);
    }

    public function detail()
    {
      $get = PrRapelGajiDetail::select('nip', 'nama', 'tanggal_proses', 'jml_bulan_selisih', 'nilai_rapel')
        ->join('master_pegawai', 'master_pegawai.id', '=', 'pr_rapel_gaji_detail.id_pegawai')
        ->join('pr_rapel_gaji', 'pr_rapel_gaji.id', '=', 'pr_rapel_gaji_detail.id_rapel_gaji')
        ->get();

      return view('pages.rapelGaji.detailrapelgaji')->with('data', $get);
    }

    public function getclienthistory(Request $request)
    {
      $get = PrHistoriGajiPokokPerClient::where('id_cabang_client', $request->id_cabang_client)->orderby('id', 'desc')->get();
      $getasc = PrHistoriGajiPokokPerClient::where('id_cabang_client', $request->id_cabang_client)->orderby('id', 'asc')->get();
      $getClient  = MasterClient::select('id', 'nama_client')->get();
      $getCabang = MasterClientCabang::select('id','kode_cabang','nama_cabang', 'id_client')->get();
      $getClientByID = MasterClientCabang::where('master_client_cabang.id', $request->id_cabang_client)->get();

      return view('pages.rapelGaji.index')
        ->with('historydata', $get)
        ->with('historydataasc', $getasc)
        ->with('getClient', $getClient)
        ->with('getClientByID', $getClientByID)
        ->with('getCabang', $getCabang);
    }

    public function proses($id)
    {
      $get = PrHistoriGajiPokokPerClient::find($id);
      $date = explode('-', $get->tanggal_penyesuaian);
      $tahunpenyesuaianterakhir = $date[0];

      $get->flag_rapel_gaji = 1;
      $get->save();

      $set = new PrRapelGaji;
      $set->id_histori = $get->id;
      $set->tanggal_proses = date('Y-m-d');

      if ($set->save()) {
        $getpegawai = HrPkwt::join('master_pegawai', 'master_pegawai.id', '=', 'hr_pkwt.id_pegawai')
          ->where('hr_pkwt.id_cabang_client', $get->id_cabang_client)
          ->where('master_pegawai.status', 1)
          ->get();
        $idpegawai = array();
        foreach ($getpegawai as $key) {
          $idpegawai[] = $key->id_pegawai;
        }

        $batchprocessed = PrBatchProcessed::orderby('id_periode')->orderby('tanggal_proses_payroll', 'desc')->get();
        $gajipegawai = MasterPegawai::select('id', 'gaji_pokok')->get();
        $historigaji = PrHistoriGajiPokok::orderby('id_pegawai')->orderby('periode_tahun', 'desc')->get();
        $getperiode = PrPeriodeGajiDetail::all();
        $idpegawai_unique = array_unique($idpegawai);
        foreach ($idpegawai_unique as $uniqueid) {
          foreach ($getperiode as $periode) {
            if ($periode->id_pegawai == $uniqueid) {
              $pegawaiperiode = $periode->id_periode_gaji;
              foreach ($batchprocessed as $bp) {
                if ($bp->id_periode == $pegawaiperiode) {
                  $terakhirgajian = $bp->tanggal_proses_payroll;
                  $exp = explode('-', $terakhirgajian);
                  $bulanterakhirgajian = $exp[1];

                  $gajisekarang = 0;
                  foreach ($gajipegawai as $gp) {
                    if ($gp->id == $uniqueid) {
                      $gajisekarang = $gp->gaji_pokok;
                      break;
                    }
                  }
                  $gajisebelumnya = 0;
                  foreach ($historigaji as $hg) {
                    if ($hg->id_pegawai == $uniqueid && $hg->periode_tahun == $tahunpenyesuaianterakhir-1) {
                      $gajisebelumnya = $hg->gaji_pokok;
                      break;
                    }
                  }

                  $selisih = $gajisekarang - $gajisebelumnya;
                  $nilairapel = $selisih * $bulanterakhirgajian;

                  $setrapel = new PrRapelGajiDetail;
                  $setrapel->id_pegawai = $uniqueid;
                  $setrapel->id_rapel_gaji = $set->id;
                  $setrapel->jml_bulan_selisih = $bulanterakhirgajian;
                  $setrapel->nilai_rapel = $nilairapel;
                  $setrapel->save();

                  break;
                }
              }
              break;
            }
          }
        }
      }

      return redirect()->route('rapelgaji.list')->with('message', 'Berhasil memproses rapel gaji.');
    }
}
