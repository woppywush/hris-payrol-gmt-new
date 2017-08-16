<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterPegawai;
use App\Models\HrPkwt;

use DB;

class HariKerjaController extends Controller
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

      $listNew = DB::select("select a.*, b.id as client_id, b.kode_client as kode_client, b.nama_client as nama_client,
      (select count(1) from hr_pkwt d where d.id_cabang_client = a.id) as total_pegawai
      FROM master_client_cabang a left join master_client b on a.id_client = b.id where exists (select * from hr_pkwt c where c.id_cabang_client = a.id)");

      $getlistClientNew = collect($listNew);

      return view('pages.hariKerja.index', compact('getlistClientNew'));
    }

    public function store(Request $request)
    {
      if ($request->idcabangclient != null) {
        foreach ($request->idcabangclient as $key1) {
          $check = HrPkwt::where('id_cabang_client', $key1)->get();
            foreach ($check as $key2) {
              $dataChage = MasterPegawai::find($key2->id_pegawai);
              $dataChage->workday = $request->workday;
              $dataChage->save();
            }
        }
          return redirect()->route('harikerja.index')->with('message', 'Berhasil memasukkan seluruh data hari kerja perclient.');
      } else {
          return redirect()->route('harikerja.index')->with('gagal', 'Pilih data client tersebuh dahulu.');
      }
    }
}
