<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Models\HrPkwt;
use App\Models\MasterPegawai;
use App\Models\MasterClient;
use App\Models\MasterClientCabang;
use App\Models\HrHistoriPegawai;

use Datatables;
use Carbon\Carbon;
use DB;
use Validator;
use Excel;

class PkwtController extends Controller
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

      return view('pages.pkwt.index');
    }

    public function getPKWTforDataTables()
    {
      $pkwt = HrPkwt::join('master_client_cabang', 'master_client_cabang.id', '=', 'hr_pkwt.id_cabang_client')
                ->join('master_client', 'master_client.id', '=', 'master_client_cabang.id_client')
                ->select(['pegawai.nip as nip','pegawai.nip_lama','pegawai.nama as nama','tanggal_awal_pkwt', 'tanggal_akhir_pkwt', 'spv.nama as id_kelompok_jabatan', DB::raw('CONCAT(master_client.nama_client, " - ", master_client_cabang.nama_cabang) AS nama_cabang')])
                ->join('master_pegawai as pegawai','hr_pkwt.id_pegawai','=', 'pegawai.id')
                ->join('master_pegawai as spv', 'hr_pkwt.id_kelompok_jabatan', '=', 'spv.id')
                ->where('status_pkwt', 1)
                ->get();

      return Datatables::of($pkwt)
        ->addColumn('keterangan', function($pkwt){
          $tgl = explode('-', $pkwt->tanggal_akhir_pkwt);
          $tglakhir = Carbon::createFromDate($tgl[0], $tgl[1], $tgl[2]);
          $now = gmdate("Y-m-d", time()+60*60*7);
          $tglskrg = explode('-', $now);
          $result = Carbon::createFromDate($tglskrg[0],$tglskrg[1],$tglskrg[2])->diffInDays($tglakhir, false);
          if($result == 0)
          {
            return "<span class='label bg-yellow'>Expired Hari Ini</span>";
          }
          else if($result < 0)
          {
            return "<span class='label bg-red'>Telah Expired</span>";
          }
          else if($result > 30)
          {
            return "<span class='label bg-green'>PKWT Aktif</span>";
          }
          else if($result > 0)
          {
            return "<span class='label bg-yellow'>Expired Dalam ".$result." Hari</span>";
          }
        })
        ->addColumn('action', function($pkwt){
          return '<a href="pkwt-detail/'.$pkwt->nip.'" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Lihat Detail"><i class="fa fa-eye"></i></a>';
        })
        ->editColumn('status_karyawan_pkwt', function($pkwt){
          if($pkwt->status_karyawan_pkwt==1)
            return "Kontrak";
          else if($pkwt->status_karyawan_pkwt==2)
            return "Freelance";
          else if($pkwt->status_karyawan_pkwt==3)
            return "Tetap";
        })
        ->make();
    }

    public function create()
    {
      $getnip = MasterPegawai::select('id','nip','nama')->where('status', 1)->get();
      $get_kel_jabatan = MasterPegawai::select('id','nip','nama')->where('id_jabatan', '=', '999')->where('status', 1)->get();

      $getclient  = MasterClient::select('id', 'nama_client')->get();
      $getcabang = MasterClientCabang::select('id','kode_cabang','nama_cabang', 'id_client')->get();

      return view('pages.pkwt.tambah', compact('getnip', 'get_kel_jabatan', 'getclient', 'getcabang'));
    }

    public function store(Request $request)
    {
      $message = [
        'tanggal_masuk_gmt.required' => 'Wajib di isi',
        'tanggal_masuk_client.required' => 'Wajib di isi',
        'status_pkwt.required' => 'Wajib di isi',
        'tanggal_awal_pkwt.required' => 'Wajib di isi',
        'tanggal_akhir_pkwt.required' => 'Wajib di isi',
        'status_karyawan_pkwt.required' => 'Wajib di isi',
        'id_pegawai.required' => 'Wajib di isi',
        'id_kelompok_jabatan.required' => 'Wajib di isi',
        'id_cabang_client.required' => 'Wajib di isi',
  		];

  		$validator = Validator::make($request->all(), [
  			'tanggal_masuk_gmt' => 'required',
  			'tanggal_masuk_client' => 'required',
        'status_pkwt' => 'required',
        'tanggal_awal_pkwt' => 'required',
        'tanggal_akhir_pkwt' => 'required',
        'status_karyawan_pkwt' => 'required',
        'id_pegawai' => 'required',
        'id_kelompok_jabatan' => 'required',
  			'id_cabang_client' => 'required',
  		], $message);

  		if($validator->fails()){
  			return redirect()->route('pkwt.create')->withErrors($validator)->withInput();
  		}


      $set = new HrPkwt;
      $set->tanggal_masuk_gmt = $request->tanggal_masuk_gmt;
      $set->tanggal_masuk_client = $request->tanggal_masuk_client;
      $set->status_pkwt = $request->status_pkwt;
      $set->tanggal_awal_pkwt = $request->tanggal_awal_pkwt;
      $set->tanggal_akhir_pkwt = $request->tanggal_akhir_pkwt;
      $set->status_karyawan_pkwt = $request->status_karyawan_pkwt;
      $set->id_pegawai = $request->id_pegawai;
      $set->id_kelompok_jabatan = $request->id_kelompok_jabatan;
      $set->id_cabang_client = $request->id_cabang_client;
      $set->flag_terminate = '1';
      $set->save();

      return redirect()->route('pkwt.index');
    }

    public function getPKWTforDashboard()
    {
      $pkwt = HrPkwt::select(['nip','nama','tanggal_awal_pkwt', 'tanggal_akhir_pkwt', 'status_karyawan_pkwt'])
        ->join('master_pegawai','hr_pkwt.id_pegawai','=', 'master_pegawai.id')->get();

      return Datatables::of($pkwt)
        ->addColumn('keterangan', function($pkwt){
          $tgl = explode('-', $pkwt->tanggal_akhir_pkwt);
          $tglakhir = Carbon::createFromDate($tgl[0], $tgl[1], $tgl[2]);
          $now = gmdate("Y-m-d", time()+60*60*7);
          $tglskrg = explode('-', $now);
          $result = Carbon::createFromDate($tglskrg[0],$tglskrg[1],$tglskrg[2])->diffInDays($tglakhir, false);
          if($result == 0)
          {
            return "<span class='label bg-yellow'>Expired Hari Ini</span>";
          }
          else if($result < 0)
          {
            return "<span class='label bg-red'>Telah Expired</span>";
          }
          else if($result > 30)
          {
            return "<span class='label bg-green'>PKWT Aktif</span>";
          }
          else if($result > 0)
          {
            return "<span class='label bg-yellow'>Expired Dalam ".$result." Hari</span>";
          }
        })
        ->editColumn('status_karyawan_pkwt', function($pkwt){
          if($pkwt->status_karyawan_pkwt==1)
            return "Kontrak";
          else if($pkwt->status_karyawan_pkwt==2)
            return "Freelance";
          else if($pkwt->status_karyawan_pkwt==3)
            return "Tetap";
        })
        ->make();
    }

    public function detail($nip)
    {
      $getnip = MasterPegawai::where('nip', $nip)->get();
      $id_pegawai = $getnip[0]->id;

      $getpkwt = HrPkwt::join('master_pegawai as spv', 'spv.id', '=', 'hr_pkwt.id_kelompok_jabatan')
                      ->join('master_pegawai', 'master_pegawai.id', '=', 'hr_pkwt.id_pegawai')
                      ->join('master_client_cabang', 'master_client_cabang.id', '=', 'hr_pkwt.id_cabang_client')
                      ->join('master_client', 'master_client.id', '=', 'master_client_cabang.id_client')
                      ->join('master_jabatan', 'master_jabatan.id', '=', 'master_pegawai.id_jabatan')
                      ->select('hr_pkwt.*', 'master_pegawai.nama', 'spv.nama', 'master_client.nama_client', 'master_client_cabang.nama_cabang')
                      ->where('hr_pkwt.id_pegawai', $id_pegawai)
                      ->orderBy('tanggal_akhir_pkwt', 'DESC')
                      ->get();

      $get_kel_jabatan = MasterPegawai::select('id','nip','nama')->where('id_jabatan', '=', '999')->get();

      return view('pages.pkwt.lihat', compact('getnip', 'getpkwt', 'get_kel_jabatan'));
    }

    public function bind($id)
    {
      $get = HrPkwt::find($id);

      return $get;
    }

    public function saveChangesPKWT(Request $request)
    {
      $message = [
        'tanggal_masuk_gmt.required' => 'Wajib di isi',
        'tanggal_masuk_client.required' => 'Wajib di isi',
        'status_pkwt.required' => 'Wajib di isi',
        'tanggal_awal_pkwt.required' => 'Wajib di isi',
        'tanggal_akhir_pkwt.required' => 'Wajib di isi',
        'status_karyawan_pkwt.required' => 'Wajib di isi',
        'id_pegawai.required' => 'Wajib di isi',
        'id_kelompok_jabatan.required' => 'Wajib di isi',
        'id_cabang_client.required' => 'Wajib di isi',
  		];

  		$validator = Validator::make($request->all(), [
  			'tanggal_masuk_gmt' => 'required',
  			'tanggal_masuk_client' => 'required',
        'status_pkwt' => 'required',
        'tanggal_awal_pkwt' => 'required',
        'tanggal_akhir_pkwt' => 'required',
        'status_karyawan_pkwt' => 'required',
        'id_pegawai' => 'required',
        'id_kelompok_jabatan' => 'required',
  			'id_cabang_client' => 'required',
  		], $message);

  		if($validator->fails()){
  			return redirect()->route('pkwt.detail', ['id' => $request->nip])->withErrors($validator)->withInput()->with('gagal');
  		}

      $set = HrPkwt::find($request->id_pkwt_change);
      $set->tanggal_masuk_gmt = $request->tanggal_masuk_gmt;
      $set->tanggal_masuk_client = $request->tanggal_masuk_client;
      $set->tanggal_awal_pkwt = $request->tanggal_awal_pkwt;
      $set->tanggal_akhir_pkwt = $request->tanggal_akhir_pkwt;
      $set->status_karyawan_pkwt = $request->status_karyawan_pkwt;
      $set->status_pkwt = $request->status_pkwt;
      $set->id_kelompok_jabatan = $request->id_kelompok_jabatan;
      $set->save();

      return redirect()->route('pkwt.detail', $request->nip)->with('message', 'Berhasil mengubah data PKWT.');
    }

    public function terminatePKWT(Request $request)
    {
      $setPKWT = HrPkwt::find($request->id_pkwt);
      $setPKWT->flag_terminate = '0';
      $setPKWT->status_pkwt = '0';
      $setPKWT->save();

      $bindPegawai = HrPkwt::join('master_pegawai', 'master_pegawai.id', '=', 'hr_pkwt.id_pegawai')
                    ->select('master_pegawai.id', 'master_pegawai.nip')
                    ->where('hr_pkwt.id', $request->id_pkwt)
                    ->first();

      $setHistori = new HrHistoriPegawai;
      $setHistori->keterangan = $request->keterangan;
      $setHistori->id_pegawai = $bindPegawai->id;
      $setHistori->save();

      return redirect()->route('pkwt.detail', $bindPegawai->nip)->with('terminate', 'PKWT Berhasil di-Terminate.');
    }


    public function import()
    {
      return view('pages.pkwt.import');
    }

    public function getTemplate()
    {
      $pegawai = MasterPegawai::select('nip', 'nama', 'jenis_kelamin')
                                ->where('status', 1)
                                ->get()
                                ->toArray();

      $supervisi = MasterPegawai::select('nip as nip_spv', 'nama', 'jenis_kelamin')
                                ->where('id_jabatan', '=', '999')
                                ->get()
                                ->toArray();

      $client = MasterClientCabang::join('master_client', 'master_client.id', '=', 'master_client_cabang.id_client')
                                  ->select('master_client_cabang.kode_cabang','master_client.nama_client', 'master_client_cabang.nama_cabang')
                                  ->get()
                                  ->toArray();

      return Excel::create('Template Import Data Pkwt', function($excel) use($pegawai, $supervisi, $client)
      {
        $excel->sheet('Data-Import', function($sheet)
        {
          $sheet->setOrientation('landscape');
          $sheet->row(1, array('nip', 'kode_cabang','nip_spv', 'tanggal_masuk_gmt', 'tanggal_masuk_client', 'tanggal_awal_pkwt', 'tanggal_akhir_pkwt', 'status_karyawan_pkwt', 'status_pkwt'));
          $sheet->setColumnFormat(array(
            'A' => '@',
            'B' => '@',
            'C' => '@',
            'D' => 'yyyy-mm-dd',
            'E' => 'yyyy-mm-dd',
            'F' => 'yyyy-mm-dd',
            'G' => 'yyyy-mm-dd',
            'H' => '@',
            'I' => '@',
          ));
        });

        $excel->sheet('pegawai', function($sheet) use($pegawai)
        {
          $sheet->row(1, array('Untuk Import Data PKWT Gunakan NIP'));
          $sheet->mergeCells('A1:C1');
          $sheet->cells('A1:C1', function($cells){
            $cells->setBackground('#000000');
            $cells->setFontColor('#ffffff');
            $cells->setFontWeight('bold');
            $cells->setFontSize(16);
          });
          $sheet->fromArray($pegawai, null, 'A2', true);
          $sheet->row(2, array('nip','nama', 'jenis_kelamin'));
          $sheet->setAllBorders('thin');
          $sheet->setFreeze('A1');

          $sheet->cells('A2:C2', function($cells){
            $cells->setBackground('#000000');
            $cells->setFontColor('#ffffff');
            $cells->setFontWeight('bold');
          });


        });

        $excel->sheet('supervisi', function($sheet) use($supervisi)
        {
          $sheet->fromArray($supervisi, null, 'A1', true);
          $sheet->row(1, array('nip_spv','nama','jenis_kelamin'));
          $sheet->setAllBorders('thin');
          $sheet->setFreeze('A1');

          $sheet->cells('A1:C1', function($cells){
            $cells->setBackground('#000000');
            $cells->setFontColor('#ffffff');
            $cells->setFontWeight('bold');
          });
        });

        $excel->sheet('client', function($sheet) use($client)
        {
          $sheet->fromArray($client, null, 'A1', true);
          $sheet->row(1, array('kode_cabang', 'nama_client', 'nama_cabang'));
          $sheet->setAllBorders('thin');
          $sheet->setFreeze('A1');

          $sheet->cells('A1:C1', function($cells){
            $cells->setBackground('#000000');
            $cells->setFontColor('#ffffff');
            $cells->setFontWeight('bold');
          });
        });

        $excel->sheet('tambahan', function($sheet)
        {
          $sheet->row(3, array('Status Karyawan', 'kode_input'));
          $sheet->row(4, array('Kontrak', '1'));
          $sheet->row(5, array('Freelance', '2'));
          $sheet->row(6, array('Tetap', '3'));

          $sheet->row(7, array('Status PKWT', 'kode_input'));
          $sheet->row(8, array('Aktif', '1'));
          $sheet->row(9, array('Tidak Aktif', '0'));
        });

      })->download('xlsx');


    }

    public function proses(Request $request)
    {
        $timestamps = date('Y-m-d h:m:s');

        if(Input::hasFile('importPkwt')){
          $path = Input::file('importPkwt')->getRealPath();
          $data = Excel::selectSheets('Data-Import')->load($path, function($reader) {})->get();

          $getPegawai = MasterPegawai::select('id','nip')->where('status', 1)->get();
          $getCabang = MasterClientCabang::select('id', 'kode_cabang')->get();
          $getPkwt = HrPkwt::where('status_pkwt', 1)->where('flag_terminate', 1)->get();

          if(!empty($data) && $data->count()){
            foreach ($data as $key) {

              foreach ($getPegawai as $pegawai) {
                if($pegawai->nip == $key->nip){
                  $nip = $pegawai->id;
                }
              }

              foreach ($getPegawai as $spv) {
                if($spv->nip == $key->nip_spv){
                  $nip_spv = $spv->id;
                }
              }

              foreach ($getCabang as $cabang) {
                if($cabang->kode_cabang == $key->kode_cabang){
                  $cabangnya = $cabang->id;
                }
              }

              // foreach ($getPkwt as $pkwt) {
              //   if($pkwt->id_pegawai == $nip){
              //     if($pkwt->tanggal_akhir_pkwt < $key->tanggal_awal_pkwt){
              //       $insert[] = ['id_pegawai'           => $nip,
              //                    'id_cabang_client'     => $cabangnya,
              //                    'id_kelompok_jabatan'  => $nip_spv,
              //                    'tanggal_masuk_gmt'    => $key->tanggal_masuk_gmt,
              //                    'tanggal_masuk_client' => $key->tanggal_masuk_client,
              //                    'tanggal_awal_pkwt'    => $key->tanggal_awal_pkwt,
              //                    'tanggal_akhir_pkwt'   => $key->tanggal_akhir_pkwt,
              //                    'status_karyawan_pkwt' => $key->status_karyawan_pkwt,
              //                    'status_pkwt'          => $key->status_pkwt,
              //                    'flag_terminate'       => 1,
              //                    'created_at'           => $timestamps,
              //                    'updated_at'           => $timestamps,
              //                  ];
              //     }else{
              //       $gagal[] = ['id_pegawai'           => $nip,
              //                    'id_cabang_client'     => $cabangnya,
              //                    'id_kelompok_jabatan'  => $nip_spv,
              //                    'tanggal_masuk_gmt'    => $key->tanggal_masuk_gmt,
              //                    'tanggal_masuk_client' => $key->tanggal_masuk_client,
              //                    'tanggal_awal_pkwt'    => $key->tanggal_awal_pkwt,
              //                    'tanggal_akhir_pkwt'   => $key->tanggal_akhir_pkwt,
              //                    'status_karyawan_pkwt' => $key->status_karyawan_pkwt,
              //                    'status_pkwt'          => $key->status_pkwt,
              //                    'flag_terminate'       => 1,
              //                    'created_at'           => $timestamps,
              //                    'updated_at'           => $timestamps,
              //                  ];
              //     }
              //   }
              // }

              $insert[] = ['id_pegawai'           => $nip,
                           'id_cabang_client'     => $cabangnya,
                           'id_kelompok_jabatan'  => $nip_spv,
                           'tanggal_masuk_gmt'    => $key->tanggal_masuk_gmt,
                           'tanggal_masuk_client' => $key->tanggal_masuk_client,
                           'tanggal_awal_pkwt'    => $key->tanggal_awal_pkwt,
                           'tanggal_akhir_pkwt'   => $key->tanggal_akhir_pkwt,
                           'status_karyawan_pkwt' => $key->status_karyawan_pkwt,
                           'status_pkwt'          => $key->status_pkwt,
                           'flag_terminate'       => 1,
                           'created_at'           => $timestamps,
                           'updated_at'           => $timestamps,
                         ];
            }

            if(!empty($insert)){
              DB::table('hr_pkwt')->insert($insert);

              if(!empty($gagal)){
                return redirect()->route('pkwtImport')->with('message', 'Berhasil Meng-Import Data PKWT.')->with('gagal');
              }

              return redirect()->route('pkwtImport')->with('message', 'Berhasil Meng-Import Data PKWT.');
            }
          }
        }

        return back()->with('error', 'Harap Pilih File Sesuai Dengan Template');
    }



}
