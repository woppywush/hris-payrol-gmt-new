<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterJabatan;
use DB;
use Validator;

class MasterJabatanController extends Controller
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

    public function create()
    {
        $getjabatan = MasterJabatan::where('status', 1)->orderBy('nama_jabatan', 'ASC')->paginate(20);

        $getjabatan2 = MasterJabatan::get();
        $get = array();
        $kode = 0;
        foreach ($getjabatan2 as $key) {
          $get[$kode] = $key->kode_jabatan;
          $kode++;
        }
          if ($kode != 0) {
             $kodegenerate = $kode + 1;
             $kodegenerate = "JB".str_pad($kodegenerate, 3, "0", STR_PAD_LEFT);
          } else {
              $kodegenerate = "JB001";
          }

        $data['getjabatan'] = $getjabatan;
        $data['kodegenerate'] = $kodegenerate;

        return view('pages.masterjabatan.index')->with('data', $data);
    }

    public function store(Request $request)
    {
      $message = [
        'nama_jabatan.required' => 'Wajib di isi.',
      ];

      $validator = Validator::make($request->all(),[
        'nama_jabatan' => 'required',
      ], $message);

      if($validator->fails()){
        return redirect()->route('masterjabatan.create')->withErrors($validator)->withInput();
      }

        $jabatan = new MasterJabatan;
        $jabatan->kode_jabatan = $request->kode_jabatan;
        $jabatan->nama_jabatan = strtoupper($request->nama_jabatan);
        $jabatan->status = 1;
        $jabatan->save();

        return redirect()->route('masterjabatan.create')->with('message', 'Data jabatan berhasil dimasukkan.');
    }

    public function edit($id)
    {
        $getjabatan = MasterJabatan::where('status', 1)->orderBy('nama_jabatan', 'ASC')->paginate(20);
        $data['getjabatan'] = $getjabatan;
        $bindjabatan = MasterJabatan::find($id);
        $data['bindjabatan'] = $bindjabatan;
        return view('pages.masterjabatan.index')->with('data', $data);
    }

    public function update(Request $request, $id)
    {
        $message = [
          'nama_jabatan.required' => 'Wajib di isi.',
        ];

        $validator = Validator::make($request->all(),[
          'nama_jabatan' => 'required',
        ], $message);

        if($validator->fails()){
          return redirect()->route('masterjabatan.update', ['id' => $id])->withErrors($validator)->withInput();
        }

        $newchanges = MasterJabatan::find($id);
        $newchanges->kode_jabatan = $request->kode_jabatan;
        $newchanges->nama_jabatan = strtoupper($request->nama_jabatan);
        $newchanges->save();

        return redirect()->route('masterjabatan.create')->with('message', 'Data jabatan berhasil diubah.');
    }

    public function hapusJabatan($id)
    {
      $updatestatus = MasterJabatan::find($id);
      $updatestatus->status = 0;
      $updatestatus->save();

      return redirect()->route('masterjabatan.create')->with('message', 'Berhasil menghapus data jabatan.');
    }
}
