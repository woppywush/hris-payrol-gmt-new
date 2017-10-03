<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterPegawai;
use App\Models\HrPkwt;
use App\Models\MasterClient;
use App\Models\MasterClientCabang;
use App\Models\PrHistoriGajiPokok;
use App\Models\PrHistoriGajiPokokPerClient;

use DB;
use Validator;
use Datatables;

class HistoryGajiPokokController extends Controller
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
      $listNew = DB::select("select a.*, b.id as client_id, b.kode_client as kode_client, b.nama_client as nama_client,
		    (select count(DISTINCT d.id_pegawai) from hr_pkwt d where d.id_cabang_client = a.id) as total_pegawai
        FROM master_client_cabang a left join master_client b on a.id_client = b.id where exists (select * from hr_pkwt c where c.id_cabang_client = a.id)");

      $getlistClientNew = collect($listNew);

      return view('pages.gaji.gajiPokok', compact('getlistClientNew'));
    }

    public function getDataForDataTable()
    {
      $gethistorygajipokok = PrHistoriGajiPokok::select(['master_pegawai.nip as nip_pegawai', 'master_pegawai.nama as nama_pegawai', 
          'master_pegawai.no_telp as no_telp_pegawai', 'pr_histori_gaji_pokok.periode_tahun', 'pr_histori_gaji_pokok.gaji_pokok',
          'pr_histori_gaji_pokok.created_at', 'master_client.nama_client as nama_client', 'master_client_cabang.nama_cabang',
          DB::raw("if(master_pegawai.status = 1, 'Aktif', 'Tidak Aktif') as status")])
        ->leftJoin('master_pegawai', 'pr_histori_gaji_pokok.id_pegawai', '=', 'master_pegawai.id')
        ->leftJoin('master_client_cabang', 'pr_histori_gaji_pokok.id_cabang_client', '=', 'master_client_cabang.id')
        ->leftJoin('master_client', 'master_client_cabang.id_client', '=', 'master_client.id')
        ->get();

        return Datatables::of($gethistorygajipokok)
        ->editColumn('status', function($user){
          if ($user->status=="Aktif") {
            return "<span class='badge bg-green'>Aktif</span>";
          } else {
            return "<span class='badge bg-red'>Tidak Aktif</span>";
          }
        })
        ->make();
        
    }

    public function store(Request $request)
    {
      // dd($request);
     
      $message = [
        'gaji_pokok.required' => 'Wajib di isi',
        'keterangan.required' => 'Wajib di isi',
      ];

      $validator = Validator::make($request->all(), [
        'gaji_pokok' => 'required',
        'keterangan' => 'required',
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('historygajipokok.index')->withErrors($validator)->withInput();
      }

      $cabangclient = MasterClientCabang::all();

      if ($request->idcabangclient != null) {

        foreach ($request->idcabangclient as $key1) {

          // SAVE TO HISTORI GAJI POKOK PER CLIENT BY DUDY //
          $idclient = 0;
          foreach ($cabangclient as $cc) {
            if ($cc->id==$key1) {
              $idclient = $cc->id_client;
              break;
            }
          }
          
          $checkhistory2 = PrHistoriGajiPokokPerClient::where('id_client', $idclient)->where('tanggal_penyesuaian','like',
            "$request->periode_tahun%")->first();
          if ($checkhistory2 == null) {
            $newrow = new PrHistoriGajiPokokPerClient;
            $newrow->id_client = $idclient;
            $newrow->id_cabang_client = $key1;
            $newrow->tanggal_penyesuaian = date('Y-m-d');
            $newrow->nilai = $request->gaji_pokok;
            $newrow->save();
          }else{
            $setdata = PrHistoriGajiPokokPerClient::find($checkhistory2->id);
            $setdata->id_client = $idclient;
            $setdata->id_cabang_client = $key1;
            $setdata->tanggal_penyesuaian = date('Y-m-d');
            $setdata->nilai = $request->gaji_pokok;
            $setdata->save();
          }
          
          // SAVE TO HISTORI GAJI POKOK PER CLIENT BY DUDY //

          $check = HrPkwt::where('id_cabang_client', $key1)->get();
            foreach ($check as $key2) {
              $dataChage = MasterPegawai::find($key2->id_pegawai);
              $dataChage->gaji_pokok = $request->gaji_pokok;
              $dataChage->save();
              $checkhistory = PrHistoriGajiPokok::where('id_pegawai', $key2->id_pegawai)->where('periode_tahun', $request->periode_tahun)->first();
              if ($checkhistory != null) {
                $set = PrHistoriGajiPokok::where('id_pegawai', $key2->id_pegawai)->where('periode_tahun', $request->periode_tahun)->first();
                $set->gaji_pokok = $request->gaji_pokok;
                $set->periode_tahun = $request->periode_tahun;
                $set->keterangan = $request->keterangan;
                $set->id_pegawai = $key2->id_pegawai;
                $set->id_cabang_client = $key1;
                $set->flag_status = 0;
                $set->save();
              } else {
                $set = new PrHistoriGajiPokok;
                $set->gaji_pokok = $request->gaji_pokok;
                $set->periode_tahun = $request->periode_tahun;
                $set->keterangan = $request->keterangan;
                $set->id_pegawai = $key2->id_pegawai;
                $set->id_cabang_client = $key1;
                $set->flag_status = 0;
                $set->save();
              }
            }
        }
          return redirect()->route('historygajipokok.index')->with('message', 'Berhasil memasukkan seluruh data history gaji pokok perclient.');
      } else {
          return redirect()->route('historygajipokok.index')->with('gagal', 'Pilih data client tersebuh dahulu.');
      }
    }
}
