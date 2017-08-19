<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterClient;
use App\Models\MasterPegawai;

use DB;

class SpvController extends Controller
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
        $getClient  = MasterClient::get();

        return view('pages.supervisi.index', compact('getClient'));
    }

    public function proses(Request $request)
    {
      $id_client = $request->id_client;

      $getClient  = MasterClient::get();

      $getExistClient = MasterClient::where('id', $id_client)->get();

      $getSpv  = MasterClient::join('master_client_cabang as A', 'A.id_client', '=', 'master_client.id')
                          ->join('hr_pkwt as D', 'A.id', '=', 'D.id_cabang_client')
                          ->join('master_pegawai as C', 'C.id', '=', 'D.id_pegawai')
                          ->join('master_pegawai as SPV', 'SPV.id', '=', 'D.id_kelompok_jabatan')
                          ->join('master_jabatan as E', 'SPV.id_jabatan', '=', 'E.id')
                          ->select('master_client.nama_client', 'A.nama_cabang', 'C.nama as nama_karyawan', 'D.tanggal_awal_pkwt', 'D.tanggal_akhir_pkwt', 'E.nama_jabatan', 'SPV.nama as spv')
                          ->where('E.id', '999')
                          ->where('c.status', 1)
                          ->where('master_client.id',  $id_client)
                          ->where('D.status_pkwt', '1')
                          ->where('D.flag_terminate', '1')
                          ->get();

      $spvExist = MasterPegawai::select('master_pegawai.id','master_pegawai.nip','master_pegawai.nama')
                                ->where('master_pegawai.id_jabatan', '=', '999')
                                ->where('master_pegawai.status', 1)
                                ->get();

      return view('pages.supervisi.index', compact('getSpv', 'getClient', 'getExistClient', 'spvExist', 'id_client'));
    }

    public function edit(Request $request)
    {
      $change = DB::table('hr_pkwt')
                    ->join('master_client_cabang', 'master_client_cabang.id', '=', 'hr_pkwt.id_cabang_client')
                    ->join('master_client', 'master_client_cabang.id_client', '=', 'master_client.id')
                    ->where('hr_pkwt.id_kelompok_jabatan', $request->spv_lama)
                    ->where('master_client.id', $request->id_client)
                    ->where('hr_pkwt.status_pkwt', '1')
                    ->where('hr_pkwt.flag_terminate', '1')
                    ->update(['hr_pkwt.id_kelompok_jabatan' => $request->new_spv]);

      $getClient  = MasterClient::get();

      $getExistClient = MasterClient::where('id', $request->id_client)->get();

      return redirect()->route('supervisi.index')->with('message', 'Supervisi Berhasil Digantikan.');
    }
}
