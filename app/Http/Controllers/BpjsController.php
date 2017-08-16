<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PrBpjs;
use App\Models\MasterClient;
use App\Models\MasterKomponenGaji;
use App\Models\MasterClientCabang;

use Validator;
use DB;

class BpjsController extends Controller
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
      $getbpjskesehatan = PrBpjs::leftJoin('master_client_cabang', 'pr_bpjs.id_cabang_client', '=', 'master_client_cabang.id')
                        ->leftJoin('master_komponen_gaji', 'pr_bpjs.id_bpjs', '=', 'master_komponen_gaji.id')
                        ->leftJoin('master_client', 'master_client_cabang.id_client', '=', 'master_client.id')
                        ->select('pr_bpjs.*', 'master_client.id as client_id', 'master_client.kode_client as kode_client', 'master_client.nama_client as nama_client', 'master_komponen_gaji.id as id_komgaj', 'master_komponen_gaji.nama_komponen as nama_komponen', 'master_client_cabang.nama_cabang', 'master_client_cabang.alamat_cabang')
                        ->where('id_bpjs', '9991')
                        ->get();

      $getbpjsketenagakerjaan = PrBpjs::leftJoin('master_client_cabang', 'pr_bpjs.id_cabang_client', '=', 'master_client_cabang.id')
                        ->leftJoin('master_komponen_gaji', 'pr_bpjs.id_bpjs', '=', 'master_komponen_gaji.id')
                        ->leftJoin('master_client', 'master_client_cabang.id_client', '=', 'master_client.id')
                        ->select('pr_bpjs.*', 'master_client.id as client_id', 'master_client.kode_client as kode_client', 'master_client.nama_client as nama_client', 'master_komponen_gaji.id as id_komgaj', 'master_komponen_gaji.nama_komponen as nama_komponen', 'master_client_cabang.nama_cabang', 'master_client_cabang.alamat_cabang')
                        ->where('id_bpjs', '9992')
                        ->get();

      $getbpjspensiun = PrBpjs::leftJoin('master_client_cabang', 'pr_bpjs.id_cabang_client', '=', 'master_client_cabang.id')
                        ->leftJoin('master_komponen_gaji', 'pr_bpjs.id_bpjs', '=', 'master_komponen_gaji.id')
                        ->leftJoin('master_client', 'master_client_cabang.id_client', '=', 'master_client.id')
                        ->select('pr_bpjs.*', 'master_client.id as client_id', 'master_client.kode_client as kode_client', 'master_client.nama_client as nama_client', 'master_komponen_gaji.id as id_komgaj', 'master_komponen_gaji.nama_komponen as nama_komponen', 'master_client_cabang.nama_cabang', 'master_client_cabang.alamat_cabang')
                        ->where('id_bpjs', '9993')
                        ->get();

      $listKesehatanNew = DB::select("select a.*, b.id as client_id, b.kode_client as kode_client, b.nama_client as nama_client FROM master_client_cabang a left join master_client b on a.id_client = b.id where not exists (select * from pr_bpjs c where c.id_cabang_client = a.id and c.id_bpjs = 9991)");
      $getlistBPJSKesehatanNew = collect($listKesehatanNew);

      $listKetenagakerjaanNew = DB::select("select a.*, b.id as client_id, b.kode_client as kode_client, b.nama_client as nama_client FROM master_client_cabang a left join master_client b on a.id_client = b.id where not exists (select * from pr_bpjs c where c.id_cabang_client = a.id and c.id_bpjs = 9992)");
      $getlistBPJSKetenagakerjaanNew = collect($listKetenagakerjaanNew);

      $listPensiunNew = DB::select("select a.*, b.id as client_id, b.kode_client as kode_client, b.nama_client as nama_client FROM master_client_cabang a left join master_client b on a.id_client = b.id where not exists (select * from pr_bpjs c where c.id_cabang_client = a.id and c.id_bpjs = 9993)");
      $getlistBPJSPensiunNew = collect($listPensiunNew);

      $getbpjscountkesehatan = PrBpjs::select('*')->where('id_bpjs', '9991')->count('id');
      $getbpjscountketenagakerjaan = PrBpjs::select('*')->where('id_bpjs', '9992')->count('id');
      $getbpjscountpensiun = PrBpjs::select('*')->where('id_bpjs', '9993')->count('id');

      $getClient  = MasterClient::select('id', 'nama_client')->get();
      $getCabang = MasterClientCabang::select('id','kode_cabang','nama_cabang', 'id_client')->get();

      $getKomponentGaji = MasterKomponenGaji::where(function($query) {
                return $query->where('id', '=', '9991')
                    ->orWhere('id', '=', '9992')
                    ->orWhere('id', '=', '9993');
            })->get();

      return view('pages.bpjs.index', compact('getbpjskesehatan', 'getbpjsketenagakerjaan', 'getbpjspensiun',
        'getClient', 'getKomponentGaji', 'getCabang',
        'getbpjscountkesehatan', 'getbpjscountketenagakerjaan', 'getbpjscountpensiun',
        'getlistBPJSKesehatanNew', 'getlistBPJSKetenagakerjaanNew', 'getlistBPJSPensiunNew'));
    }

    public function store(Request $request)
    {
      $message = [
        'bpjs_dibayarkan.required' => 'Wajib di isi',
      ];

      $validator = Validator::make($request->all(), [
        'bpjs_dibayarkan' => 'required',
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('bpjs.index')->withErrors($validator)->withInput();
      }

      if ($request->idcabangclient != null) {
        foreach ($request->idcabangclient as $id_cabang_client)
        {
          $set = new PrBpjs;
          $set->id_bpjs = $request->status_flag_bpjs;
          $set->keterangan = $request->keterangan;
          $set->bpjs_dibayarkan = $request->bpjs_dibayarkan;
          $set->id_cabang_client = $id_cabang_client;
          $set->save();
        }
        return redirect()->route('bpjs.index')->with('message', 'Berhasil memasukkan bpjs.');
      }else{
        return redirect()->route('bpjs.index')->with('messagefail', 'Pilih data client tersebuh dahulu.');
      }

    }

    public function bind($id)
    {
      $get = PrBpjs::find($id);
      
      return $get;
    }

    public function update(Request $request)
    {
      $dataChage = PrBpjs::find($request->id);
      $dataChage->keterangan = $request->keterangan_edit;
      $dataChage->bpjs_dibayarkan = $request->bpjs_dibayarkan_edit;
      $dataChage->save();

      return redirect()->route('bpjs.index')->with('message', 'Data bpjs berhasil diubah.');
    }

    public function delete($id)
    {
      $set = PrBpjs::find($id);
      $set->delete();

      return redirect()->route('bpjs.index')->with('message', 'Berhasil menghapus data bpjs.');
    }
}
