<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterKomponenGaji;
use App\Models\PrKomponenGajiTetap;
use App\Models\PrKomponenGajiDetail;
use App\Models\MasterClient;
use App\Models\MasterClientCabang;

use Validator;

class KomponenGajiTetapController extends Controller
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
      $getkomponen = MasterKomponenGaji::where('tipe_komponen_gaji', '=', 0)->paginate(10);

      return view('pages.masterkomponengaji.gajitetap' ,compact('getkomponen'));
    }

    public function store(Request $request)
    {
      $message = [
        'nama_komponen.required' => 'Wajib di isi',
        'tipe_komponen.required' => 'Wajib di isi',
        'periode_perhitungan.required' => 'Wajib di isi',
      ];

      $validator = Validator::make($request->all(), [
        'nama_komponen' => 'required',
        'tipe_komponen' => 'required',
        'periode_perhitungan' => 'required',
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('komgajitetap.index')->withErrors($validator)->withInput();
      }

      $set = new MasterKomponenGaji;
      $set->nama_komponen = strtoupper($request->nama_komponen);
      $set->tipe_komponen = $request->tipe_komponen;
      $set->periode_perhitungan = $request->periode_perhitungan;
      $set->tipe_komponen_gaji = 0;
      $set->save();

      return redirect()->route('komgajitetap.index')->with('message', 'Berhasil memasukkan komponen gaji tetap.');
    }

    public function update_nilai($id, $nilai)
    {
      $set = PrKomponenGajiDetail::find($id);
      $set->nilai = $nilai;
      $set->save();
    }

    public function bind($id)
    {
      $get = MasterKomponenGaji::find($id);



      return $get;
    }

    public function update(Request $request)
    {
        $dataChage = MasterKomponenGaji::find($request->id);
        $dataChage->nama_komponen = strtoupper($request->nama_komponen_edit);
        $dataChage->tipe_komponen = $request->tipe_komponen_edit;
        $dataChage->periode_perhitungan = $request->periode_perhitungan_edit;
        $dataChage->tipe_komponen_gaji = 0;
        $dataChage->save();

        return redirect()->route('komgajitetap.index')->with('message', 'Data komponen gaji berhasil diubah.');
    }

    public function delete($id)
    {
        $check = PrKomponenGajiDetail::where('id_komponen_gaji', $id)->first();

        if($check=="") {

          $set = MasterKomponenGaji::find($id);
          $set->delete();

          return redirect()->route('komgajitetap.index')->with('message', 'Berhasil menghapus data komponen gaji tetap.');
        }
        else
        {
          return redirect()->route('komgajitetap.index')->with('messagefail', 'Gagal melakukan hapus data. Data telah memiliki relasi dengan data yang lain.');
        }
    }
}
