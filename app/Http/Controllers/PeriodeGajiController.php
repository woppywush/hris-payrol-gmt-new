<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Datatables;
use App\Models\PrPeriodeGaji;
use App\Models\MasterPegawai;
use App\Models\PrHistoriGajiPokok;
use App\Models\HrPkwt;

use Validator;

class PeriodeGajiController extends Controller
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
      $getperiode = PrPeriodeGaji::orderby('tanggal')->get();

      return view('pages.periode-gaji.index')->with('getperiode', $getperiode);
    }

    public function store(Request $request)
    {
      $message = [
        'tanggal.required' => 'Wajib di isi',
        'keterangan.required' => 'Wajib di isi',
      ];

      $validator = Validator::make($request->all(), [
        'tanggal' => 'required',
        'keterangan' => 'required',
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('periodegaji.index')->withErrors($validator)->withInput();
      }

      $set = new PrPeriodeGaji;
      $set->tanggal = $request->tanggal;
      $set->keterangan = $request->keterangan;
      $set->save();

      return redirect()->route('periodegaji.index')->with('message', 'Berhasil memasukkan periode gaji.');
    }

    public function detail($id)
    {
      $getperiode = PrPeriodeGaji::find($id);

      if(!$getperiode){
        abort(404);
      }

      return view('pages.periode-gaji.detailPeriode')
              ->with('idperiode', $id)
              ->with('getperiode', $getperiode);
    }

    public function update(Request $request)
    {

      $set = MasterPegawai::find($request->id);
      $set->gaji_pokok = $request->gaji_pokok;
      $set->save();

      $checkhistory = PrHistoriGajiPokok::where('id_pegawai', $request->id)->first();
      if ($checkhistory != null) {
        $set2 = PrHistoryGajiPokok::where('id_pegawai', $request->id)->orderBy('created_at', 'desc')->first();
        $set2->gaji_pokok = $request->gaji_pokok;
        $set2->save();
      } else {
        $checkhpkwt = HrPkwt::where('id_pegawai', $request->id)->orderBy('created_at', 'desc')->first();
        $set = new PrHistoriGajiPokok;
        $set->gaji_pokok = $request->gaji_pokok;
        $set->periode_tahun = $request->periode_tahun;
        $set->id_pegawai = $request->id;
        $set->id_cabang_client = $checkhpkwt->id_cabang_client;
        $set->flag_status = 0;
        $set->save();
      }

      return redirect()->route('periodegaji.detail', $request->idperiode)->with('message', 'Berhasil mengubah gaji pokok pegawai.');
    }

    public function updateworkday(Request $request)
    {
      $set = MasterPegawai::find($request->id);
      $set->workday = $request->workday;
      $set->save();

      return redirect()->route('periodegaji.detail', $request->idperiode)->with('message', 'Berhasil mengubah hari kerja pegawai.');
    }

    public function getdatafordatatable($id)
    {
      $users = MasterPegawai::select(['master_pegawai.id as id','nip','nama','no_telp','nama_jabatan',DB::raw("if(master_pegawai.status = 1, 'Aktif', 'Tidak Aktif') as status"), 'pr_periode_gaji_detail.id as id_periode_gaji', 'master_pegawai.gaji_pokok', 'master_pegawai.workday'])
        ->join('master_jabatan','master_pegawai.id_jabatan','=', 'master_jabatan.id')
        ->join('pr_periode_gaji_detail', 'master_pegawai.id', '=', 'pr_periode_gaji_detail.id_pegawai')
        ->where('pr_periode_gaji_detail.id_periode_gaji', $id)
        ->get();

      return Datatables::of($users)
        ->addColumn('action', function($user){
            return '<span data-toggle="tooltip" title="Edit Gaji Pokok"> <a href="" class="btn btn-xs btn-warning editgaji" data-toggle="modal" data-target="#myModalEditGaji" data-value="'.$user->id.'"><i class="fa fa-money"></i></a></span> <span data-toggle="tooltip" title="Hapus Dari Periode"> <a href="" class="btn btn-xs btn-danger hapus" data-toggle="modal" data-target="#myModal" data-value="'.$user->id_periode_gaji.'"><i class="fa fa-close"></i></a></span> <span data-toggle="tooltip" title="Edit Hari Kerja"> <a href="" class="btn btn-xs btn-success editworkday" data-toggle="modal" data-target="#myModalEditWorkDay" data-value="'.$user->id.'"><i class="fa fa-clock-o"></i></a></span>';
        })
        ->editColumn('status', function($user){
          if ($user->status=="Aktif") {
            return "<span class='badge bg-green'>Aktif</span>";
          } else {
            return "<span class='badge bg-red'>Tidak Aktif</span>";
          }
        })
        ->editColumn('gaji_pokok', function($user){
          if ($user->gaji_pokok!=null or $user->gaji_pokok!=0) {
            return $user->gaji_pokok;
          } else {
            return "<span class='badge bg-red'>Belum Ada</span>";
          }
        })
        ->editColumn('workday', function($user){
          if ($user->workday!=0) {
            if ($user->workday=="52") {
              return "<span class='badge bg-purple'>5 - 2</span>";
            } else if ($user->workday=="61") {
              return "<span class='badge bg-navy'>6 - 1</span>";
            } else if ($user->workday=="70") {
              return "<span class='badge bg-maroon'>7 - 0</span>";
            }
          } else {
            return "<span class='badge bg-red'>Belum Ada</span>";
          }
        })
        ->removeColumn('id')
        ->removeColumn('id_periode_gaji')
        ->make();
    }
}
