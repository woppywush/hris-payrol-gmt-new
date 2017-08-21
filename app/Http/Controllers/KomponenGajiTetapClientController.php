<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterKomponenGaji;
use App\Models\PrKomponenGajiTetap;
use App\Models\PrKomponenGajiDetail;
use App\Models\MasterClient;
use App\Models\MasterClientCabang;

use Validator;
use DB;

class KomponenGajiTetapClientController extends Controller
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

    public function index($id)
    {

      // $getcountCabang = CabangClient::count('*');
      $getcountCabang = DB::select("select COUNT(a.id) as jmlcabnotexist FROM master_client_cabang a left join master_client b on a.id_client = b.id where not exists (select * from pr_komponen_gaji_tetap c where c.id_cabang_client = a.id and c.id_komponen_gaji = ('$id'))");

      // dd($getcountCabang);

      $getcountCabangKom = PrKomponenGajiTetap::where('id_komponen_gaji', $id)->count('*');
      $getdataKomponenGaji = MasterKomponenGaji::where('id', $id)->first();

      $listNew = DB::select("select a.*, b.id as client_id, b.kode_client as kode_client, b.nama_client as nama_client FROM master_client_cabang a left join master_client b on a.id_client = b.id where not exists (select * from pr_komponen_gaji_tetap c where c.id_cabang_client = a.id and c.id_komponen_gaji = ('$id'))");

      $getlistClientNew = collect($listNew);

      $getlistClientOld = MasterClientCabang::leftJoin('master_client', 'master_client_cabang.id_client', '=', 'master_client.id')
                      ->join('pr_komponen_gaji_tetap', 'master_client_cabang.id', '=', 'pr_komponen_gaji_tetap.id_cabang_client')
                      ->select('master_client_cabang.*', 'master_client.id as client_id', 'master_client.kode_client as kode_client', 'master_client.nama_client as nama_client', 'pr_komponen_gaji_tetap.id as id_komponen_gaji_tetap'
                        , 'pr_komponen_gaji_tetap.keterangan as keterangan_komponen_gaji_tetap'
                        , 'pr_komponen_gaji_tetap.komgaj_tetap_dibayarkan as komgaj_tetap_dibayarkan'
                        ,'pr_komponen_gaji_tetap.id_komponen_gaji as id_komponen_gaji')
                      ->where('pr_komponen_gaji_tetap.id_komponen_gaji', $id)
                      ->get();
      $getcabangclient = MasterClientCabang::select('*')->get();

      return view('pages.masterkomponengaji.gajitetapClient' ,compact('getlistClientOld','getlistClientNew',
        'getcountCabang', 'getcountCabangKom', 'getdataKomponenGaji','getcabangclient'));
    }

    public function store(Request $request)
    {
      // dd($request);
      $message = [
        'komgaj_tetap_dibayarkan.required' => 'Wajib di isi',
        'keterangan.required' => 'Wajib di isi',
      ];

      $validator = Validator::make($request->all(), [
        'komgaj_tetap_dibayarkan' => 'required',
        'keterangan' => 'required',
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('komgajitetapclient.index', $request->id_komponen_client)->withErrors($validator)->withInput();
      }

      if ($request->idcabangclient != null) {
        foreach ($request->idcabangclient as $id_cabang_client)
        {
          $set = new PrKomponenGajiTetap;
          $set->keterangan = $request->keterangan;
          $set->komgaj_tetap_dibayarkan = $request->komgaj_tetap_dibayarkan;
          $set->id_cabang_client = $id_cabang_client;
          $set->id_komponen_gaji = $request->id_komponen_client;
          $set->save();
        }
        return redirect()->route('komgajitetapclient.index', $request->id_komponen_client)->with('message', 'Berhasil memasukkan komponen gaji client.');
      }else{
        return redirect()->route('komgajitetapclient.index', $request->id_komponen_client)->withInput()->with('messagefail', 'Pilih data client tersebuh dahulu.');
      }
    }


    public function bind($id)
    {
      $get = PrKomponenGajiTetap::find($id);

      return $get;
    }


    public function update(Request $request)
    {
      $set = PrKomponenGajiTetap::find($request->id);
      $set->keterangan = $request->keterangan_edit;
      $set->komgaj_tetap_dibayarkan = $request->komgaj_tetap_dibayarkan_edit;
      $set->id_cabang_client = $request->id_cabang_client_edit;
      $set->id_komponen_gaji = $request->id_komponen_client_edit;
      $set->save();

      return redirect()->route('komgajitetapclient.index', $request->id_komponen_client_edit)->with('message', 'Data komponen gaji berhasil diubah.');
    }

    public function delete($id1, $id2)
    {
      $set = PrKomponenGajiTetap::find($id1);
      $set->delete();
      return redirect()->route('komgajitetapclient.index', $id2)->with('message', 'Berhasil menghapus data komponen gaji client.');
    }
}
