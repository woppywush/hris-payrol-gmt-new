<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;
use App\Models\MasterClient;
use App\Models\MasterClientCabang;
use App\Models\MasterClientCabangDepartemen;

class MasterClientCabangController extends Controller
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

    public function store(Request $request)
    {
      $message = [
        'kode_cabang.required'  => 'Wajib di Isi',
        'nama_cabang.required'  => 'Wajib di Isi',
        'alamat_cabang.required'  => 'Wajib di Isi',
        'id_client.required'  => 'Wajib di Isi',
      ];

      $validator = Validator::make($request->all(), [
        'kode_cabang' => 'required|max:5|unique:master_client_cabang',
				'nama_cabang' => 'required|max:40',
				'alamat_cabang' => 'required|max:150',
				'id_client' => 'required'
      ], $message);

      if($validator->fails()){
        return redirect()->route('masterclient.cabang', ['id_client' => $request->id_client])->withErrors($validator)->withInput();
      }

      $save = $request->all();
      MasterClientCabang::create($save);

      return back()->with('tambah', 'Berhasil Menambah Cabang Client Baru');
    }

    public function edit($id)
    {
      $CabangEdit = MasterClientCabang::findOrFail($id);
      $MasterClient = MasterClient::where('id', '=', $CabangEdit->id_client)->first();
      $CabangClient = MasterClientCabang::where('id_client', '=', $MasterClient->id)->paginate(10);

      return view('pages.masterclient.cabang', compact('CabangEdit','CabangClient','MasterClient'));
    }

    public function update($id, Request $request)
    {
      $message = [
        'nama_cabang.required'  => 'Wajib di Isi',
        'alamat_cabang.required'  => 'Wajib di Isi',
        'id_client.required'  => 'Wajib di Isi',
      ];

      $validator = Validator::make($request->all(), [
				'nama_cabang' => 'required|max:40',
				'alamat_cabang' => 'required|max:150',
				'id_client' => 'required'
      ], $message);

      if($validator->fails()){
        return redirect()->route('clientcabang.edit', ['id' => $request->id_client])->withErrors($validator)->withInput();
      }


      $cabangClient = MasterClientCabang::find($id);
      $lempar = $cabangClient->id_client;
      $cabangClient->update($request->all());

      return redirect()->route('masterclient.cabang', ['id' => $lempar])->with('ubah', 'Berhasil Mengubah Cabang Client');
    }
}
