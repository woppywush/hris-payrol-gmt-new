<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;
use App\Models\MasterClient;
use App\Models\MasterClientCabang;
use App\Models\MasterClientCabangDepartemen;

class MasterClientController extends Controller
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
        $getClient = DB::table('master_client')
                    ->select(DB::raw('IFNULL(count(master_client_cabang.id_client),0) as hitungCabang, master_client.*'))
                    ->leftjoin('master_client_cabang', 'master_client_cabang.id_client' , '=', 'master_client.id')
                    ->groupBy('master_client.id')
                    ->latest('master_client.updated_at')
                    ->paginate(12);

        return view('pages.masterclient.index', compact('getClient'));
    }

    public function create()
    {
      $getclient = MasterClient::get();
      $get = array();
      $kode = 0;
      foreach ($getclient as $key) {
        $get[$kode] = $key->kode_jabatan;
        $kode++;
      }
        if ($kode != 0) {
           $kodegenerate = $kode + 1;
           $kodegenerate = "CL".str_pad($kodegenerate, 3, "0", STR_PAD_LEFT);
        } else {
            $kodegenerate = "CL001";
        }

        $data['kodegenerate'] = $kodegenerate;
        return view('pages.masterclient.tambah')->with('data', $data);
    }

    public function store(Request $request)
    {
      $message = [
        'nama_client.required'  => 'Wajib di Isi'
      ];

      $validator = Validator::make($request->all(), [
        'nama_client' => 'required|max:40'
      ], $message);

      if($validator->fails()){
        return redirect()->route('masterclient.tambah')->withErrors($validator)->withInput();
      }

      $set = new MasterClient;
      $set->kode_client  = $request->kode_client;
      $set->nama_client  = $request->nama_client;
      $set->token        = hash('sha256', (random_bytes(32)));
      $set->save();

      return redirect('masterclient')->with('tambah', 'Berhasil Menambah Client Baru');
    }

    public function cabang_client_show($id)
    {
        $MasterClient = MasterClient::where('id', '=', $id)->first();
        $CabangClient = MasterClientCabang::where('id_client', '=', $id)->paginate(10);

        $AutoNum   = MasterClientCabang::latest('created_at')->first();
        if($AutoNum == null){
          $AutoNumber = '1';
        }else{
          $AutoNumber = substr($AutoNum->kode_cabang, 3)+1;
        }
        return view('pages.masterclient.cabang', compact('MasterClient','CabangClient','AutoNumber'));
    }


}
