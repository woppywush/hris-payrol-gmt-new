<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Datatables;
use App\Models\HrPkwt;
use App\Models\HrPendidikan;
use App\Models\HrBahasaAsing;
use App\Models\HrDataKeluarga;
use App\Models\MasterJabatan;
use App\Models\MasterPegawai;
use App\Models\HrDokumenPegawai;
use App\Models\HrDataPeringatan;
use App\Models\HrHistoriPegawai;
use App\Models\HrRiwayatPenyakit;
use App\Models\HrPengalamanKerja;
use App\Models\HrKondisiKesehatan;
use App\Models\HrKeahlianKomputer;
use App\Http\Requests\MasterPegawaiRequest;

class SetGajiController extends Controller
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
      return view('pages/setgajipegawai');
    }

    public function detailpegawai($id)
    {
      $DataPegawai    = MasterPegawai::join('master_jabatan', 'master_pegawai.id_jabatan', '=', 'master_jabatan.id')
                        ->select('master_pegawai.*', 'master_jabatan.nama_jabatan')
                        ->where('master_pegawai.id', '=', $id)
                        ->get();

      $DataJabatan    = MasterJabatan::all();

      $idofpegawai;
      foreach ($DataPegawai as $k) {
        $idofpegawai = $k->id;
      }

      $DataKeluarga   = HrDataKeluarga::where('id_pegawai', '=', $idofpegawai)->get();
      $DataPendidikan = HrPendidikan::where('id_pegawai', '=', $idofpegawai)->get();
      $DataPengalaman = HrPengalamanKerja::where('id_pegawai', '=', $idofpegawai)->get();
      $DataKomputer   = HrKeahlianKomputer::where('id_pegawai', '=', $idofpegawai)->get();
      $DataBahasa     = HrBahasaAsing::where('id_pegawai', '=', $idofpegawai)->get();
      $DataKesehatan  = HrKondisiKesehatan::where('id_pegawai', '=', $idofpegawai)->get();
      $DataPenyakit   = HrRiwayatPenyakit::where('id_pegawai', '=', $idofpegawai)->get();
      $DokumenPegawai = HrDokumenPegawai::where('id_pegawai', '=', $idofpegawai)->get();
      $DataPKWT       = HrPkwt::join('master_client_cabang', 'hr_pkwt.id_cabang_client','=','master_client_cabang.id')
                          ->join('master_client', 'master_client_cabang.id_client', '=', 'master_client.id')
                          ->select('master_client.nama_client', 'master_client_cabang.nama_cabang', 'hr_pkwt.tanggal_awal_pkwt as tahun_awal', 'hr_pkwt.tanggal_akhir_pkwt as tahun_akhir', 'hr_pkwt.status_karyawan_pkwt')
                          ->where('hr_pkwt.id_pegawai', $idofpegawai)
                          ->orderby('hr_pkwt.tanggal_awal_pkwt','asc')
                          ->get();
      $DataPeringatan = HrDataPeringatan::where('id_pegawai', '=', $idofpegawai)->get();
      $DataHistoriPegawai = HrHistoriPegawai::where('id_pegawai', $idofpegawai)->get();

      return view('pages/MasterPegawai/lihatdatapegawai', compact('DataJabatan', 'DataPegawai', 'DataKeluarga', 'DataPendidikan', 'DataPengalaman', 'DataKomputer', 'DataBahasa', 'DataKesehatan', 'DataPenyakit', 'DokumenPegawai', 'DataPKWT', 'DataPeringatan', 'DataHistoriPegawai'));
    }

    public function getdata()
    {
      $users = MasterPegawai::select(['master_pegawai.id as id', 'nip','nama', 'nama_jabatan', DB::raw("if(master_pegawai.status = 1, 'Aktif', 'Tidak Aktif') as status"), 'master_pegawai.gaji_pokok'])
        ->join('master_jabatan','master_pegawai.id_jabatan','=', 'master_jabatan.id')
        ->get();

      return Datatables::of($users)
        ->addColumn('action', function($user){
            return '<a href="detail-pegawai/'.$user->id.'" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Lihat Detail"><i class="fa fa-eye"></i></a> <span data-toggle="tooltip" title="Edit Gaji"> <a href="" class="btn btn-xs btn-warning editgaji" data-toggle="modal" data-target="#myModal" data-value="'.$user->id.'"><i class="fa fa-edit"></i></a></span>';
        })
        ->editColumn('status', function($user){
          if ($user->status=="Aktif") {
            return "<span class='badge bg-green'>Aktif</span>";
          } else {
            return "<span class='badge bg-red'>Tidak Aktif</span>";
          }
        })
        ->editColumn('gaji_pokok', function($user){
          if ($user->gaji_pokok==null) {
            return "<span class='badge bg-red'>Belum Ada</span>";
          } else {
            return $user->gaji_pokok;
          }
        })
        ->removeColumn('id')
        ->make();
    }

    public function bind($id)
    {
      $get = MasterPegawai::find($id);
      return $get;
    }

    public function update(Request $request)
    {
      $set = MasterPegawai::find($request->id);
      $set->gaji_pokok = $request->gajipokok;
      $set->save();

      return redirect()->route('setgaji.index')->with('message', 'Berhasil mengubah gaji pokok pegawai.');
    }
}
