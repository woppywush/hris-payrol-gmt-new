<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterPegawai;
use App\Models\MasterJabatan;
use App\Models\HrDokumenPegawai;

use Datatables;
use DB;
use Validator;
use File;

class UploadDokumenController extends Controller
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
      $getpegawai = MasterPegawai::where('status', 1)->get();
      $data['getpegawai'] = $getpegawai;
      $getdocument = HrDokumenPegawai::where('id_pegawai', 1)->get();
      $data['getdocument'] = $getdocument;

      return view('pages.uploadDokumen.index')->with('data', $data);
    }

    public function store(Request $request)
    {
      $message = [
        'id_pegawai.required' => 'Wajib di isi.',
        'nama_dokumen.*.required' => 'Wajib di isi.',
        'file_dokumen.*.required' => 'Wajib di isi.'
      ];

      $validator = Validator::make($request->all(), [
        'id_pegawai' => 'required',
        'nama_dokumen.*' => 'required',
        'file_dokumen.*' => 'required'
      ], $message);

      if($validator->fails())
      {
        return redirect()->route('uploaddokumen.index')->withErrors($validator)->withInput();
      }

      $fName  = MasterPegawai::select('nip', 'nama')->where('id', $request->id_pegawai)->get();

      $i = 1;
      foreach ($request->nama_dokumen as $key) {
        $file = $request->file_dokumen[$i];
        $file_name = strtolower($fName[0]->nip.'-'.(str_slug($fName[0]->nama, '-')).'-'.$request->nama_dokumen[$i]).'-'.rand(). '.' . $file->getClientOriginalExtension();
        $file->move('documents', $file_name);

        $set = new HrDokumenPegawai;
        $set->id_pegawai = $request->id_pegawai;
        $set->nama_dokumen = $request->nama_dokumen[$i];
        $set->file_dokumen = $file_name;
        $set->save();

        $i++;
      }

      return redirect()->route('uploaddokumen.index')->with('message', "Berhasil menyimpan dokumen pegawai.");
    }

    public function getDocforDataTables()
    {
      $dokumen = HrDokumenPegawai::select(['hr_dokumen_pegawai.id as id_doc','nip','nip_lama','nama','nama_dokumen', 'file_dokumen', 'hr_dokumen_pegawai.created_at as tanggal_upload'])
        ->join('master_pegawai','hr_dokumen_pegawai.id_pegawai','=', 'master_pegawai.id')->get();

      return Datatables::of($dokumen)
        ->editColumn('file_dokumen', function($dokumen){
          return '<a href='.url('documents').'/'.$dokumen->file_dokumen.' download><img src="'.asset('dist/img/jpg.png').'" width="15%"/></a>';
        })
        ->addColumn('action', function($dokumen){
          return '<span data-toggle="tooltip" title="Hapus Data"><a href="#" class="btn btn-xs btn-danger hapusdoc" data-value="'.$dokumen->id_doc.'" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-remove" ></i></a></span> <span data-toggle="tooltip" title="Edit Data"><a href="#" class="btn btn-xs btn-warning editdoc" data-value="'.$dokumen->id_doc.'" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-edit"></i></a></span>';
        })
        ->removeColumn('id_doc')
        ->make();
    }

    public function hapusDokumen($id)
    {
      $dokumen = HrDokumenPegawai::find($id);
      File::delete('documents/' .$dokumen->file_dokumen);
      $dokumen->delete();

      return redirect()->route('uploaddokumen.index')->with('message','Berhasil menghapus dokumen pegawai.');
    }

    public function bindData($id)
    {
      $dokumen = HrDokumenPegawai::find($id);

      return $dokumen;
    }

    public function editDokumen(Request $request)
  {
    $file = $request->file_dokumen;
    $id = $request->id_doc;
    if($file==null) {
      $set = HrDokumenPegawai::find($id);
      $set->id_pegawai = $request->id_pegawai;
      $set->nama_dokumen = $request->nama_dokumen;
      $set->save();

      return redirect()->route('uploaddokumen.index')->with('message','Berhasil mengubah dokumen pegawai.');
    } else {
      $file_name = time(). '.' . $file->getClientOriginalExtension();
      $file->move('documents', $file_name);

      $set = HrDokumenPegawai::find($id);
      $set->id_pegawai = $request->id_pegawai;
      $set->nama_dokumen = $request->nama_dokumen;
      $set->file_dokumen = $file_name;
      $set->save();

      return redirect()->route('uploaddokumen.index')->with('message','Berhasil mengubah dokumen pegawai.');
    }
  }
}
