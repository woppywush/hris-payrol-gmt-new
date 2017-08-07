<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Validator;
use App\Models\MasterClient;
use App\Models\MasterClientCabang;
use App\Models\MasterClientCabangDepartemen;

class MasterClientCabangDepartemenController extends Controller
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

    public function show($id)
    {
      $CabangClient = MasterClientCabang::where('id', '=', $id)->first();
      $DepartemenCabang = MasterClientCabangDepartemen::where('id_cabang', '=', $id)->paginate(10);

      $AutoNum   = MasterClientCabangDepartemen::latest('created_at')->first();
      if($AutoNum == null)
      {
        $AutoNumber = '1';
      }else{
        $AutoNumber = substr($AutoNum->kode_departemen, 3)+1;
      }

      return view('pages.masterclient.departemen', compact('CabangClient', 'DepartemenCabang','AutoNumber'));
    }

    public function store(Request $request)
    {
      $message = [
        'nama_departemen.required'  => 'Wajib di Isi',
        'id_cabang.required'  => 'Wajib di Isi',
      ];

      $validator = Validator::make($request->all(), [
				'nama_departemen' => 'required|max:40',
				'id_cabang' => 'required'
      ], $message);

      if($validator->fails()){
        return redirect()->route('departemen.show',['id' => $request->id_cabang])->withErrors($validator)->withInput();
      }

      $save = $request->all();
      MasterClientCabangDepartemen::create($save);

      return back()->with('tambah', 'Berhasil Menambah Departemen Baru');
    }

    public function edit($id)
    {
      $DepartemenEdit = MasterClientCabangDepartemen::findOrFail($id);
      $CabangClient     = MasterClientCabang::where('id', '=', $DepartemenEdit->id_cabang)->first();
      $DepartemenCabang = MasterClientCabangDepartemen::where('id_cabang', '=', $CabangClient->id)->paginate(10);

      return view('pages.masterclient.departemen', compact('DepartemenEdit','CabangClient','DepartemenCabang'));
    }

    public function update($id, Request $request)
    {
      $message = [
        'nama_departemen.required'  => 'Wajib di Isi',
        'id_cabang.required'  => 'Wajib di Isi',
      ];

      $validator = Validator::make($request->all(), [
				'nama_departemen' => 'required|max:40',
				'id_cabang' => 'required'
      ], $message);

      if($validator->fails()){
        return redirect()->route('departemen.edit',['id' => $request->id_cabang])->withErrors($validator)->withInput();
      }

      $DepartemenCabang = MasterClientCabangDepartemen::find($id);
      $lempar  = $DepartemenCabang->id_cabang;
      $DepartemenCabang->update($request->all());

      return redirect()->route('departemen.show', ['id' => $lempar])->with('ubah', 'Berhasil Mengubah Departemen Cabang');
    }
}
