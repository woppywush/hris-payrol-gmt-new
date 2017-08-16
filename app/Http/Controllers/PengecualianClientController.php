<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PrPengecualianClient;

use DB;

class PengecualianClientController extends Controller
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

      $getpengecualianclientold = PrPengecualianClient::leftJoin('master_client_cabang', 'pr_pengecualian_client.id_cabang_client', '=', 'master_client_cabang.id')
                        ->leftJoin('master_client', 'master_client_cabang.id_client', '=', 'master_client.id')
                        ->select('master_client_cabang.*', 'master_client.id as client_id', 'master_client.kode_client as kode_client',
                        'master_client.nama_client as nama_client', 'master_client_cabang.nama_cabang', 'master_client_cabang.alamat_cabang')
                        ->get();

        $listpengecualiancleintnew = DB::select("select a.*, b.id as client_id, b.kode_client as kode_client, b.nama_client as nama_client FROM master_client_cabang a
        left join master_client b on a.id_client = b.id where not exists (select * from pr_pengecualian_client c where c.id_cabang_client = a.id)");
        $getpengecualianclientnew = collect($listpengecualiancleintnew);

      return view('pages.hariLibur.pengecualian', compact('getpengecualianclientold', 'getpengecualianclientnew'));
    }

    public function store(Request $request)
    {
      // dd($request);
      if ($request->idcabangclientnew != null) {
          foreach ($request->idcabangclientnew as $id_cabang_client)
          {
            $set = new PrPengecualianClient;
            $set->id_cabang_client = $id_cabang_client;
            $set->flag_status = 0;
            $set->save();
          }
          return redirect()->route('pengecualian.client.index')->with('message', 'Berhasil memasukkan seluruh data hari kerja perclient.');
      } else {
          return redirect()->route('pengecualian.client.index')->with('messagefail', 'Pilih data client tersebuh dahulu.');
      }
    }

    public function delete(Request $request)
    {
      if ($request->idcabangclientold != null) {
          foreach ($request->idcabangclientold as $id_cabang_client)
          {
            $set = PrPengecualianClient::where('id_cabang_client', $id_cabang_client)->first();
            $set->id_cabang_client = $request->id_cabang_client;
            $set->delete();
          }
          return redirect()->route('pengecualian.client.index')->with('message', 'Berhasil menghapus seluruh data hari kerja perclient.');
      } else {
          return redirect()->route('pengecualian.client.index')->with('messagefail', 'Pilih data client tersebuh dahulu.');
      }
    }

}
