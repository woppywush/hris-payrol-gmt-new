<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterPegawai;
use App\Models\MasterClient;
use App\Models\HrPkwt;

use Excel;


class LaporanPegawaiController extends Controller
{
    /**
    * Authentication controller.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('isAdmin', ['except' => ['reportforclient', 'downloadExcel']]);
    }

    public function index()
    {
      $getClient  = MasterClient::get();

      return view('pages.laporan.laporanpegawai', compact('getClient'));
    }

    public function proses(Request $request)
    {

      $idClient = $request->id_client;
      $getClient  = MasterClient::get();

      $sysDate = date('Y-m-d');
      $proses = HrPkwt::join('master_pegawai as spv', 'spv.id', '=', 'hr_pkwt.id_kelompok_jabatan')
                      ->join('master_pegawai', 'master_pegawai.id', '=', 'hr_pkwt.id_pegawai')
                      ->join('master_client_cabang', 'master_client_cabang.id', '=', 'hr_pkwt.id_cabang_client')
                      ->join('master_client', 'master_client.id', '=', 'master_client_cabang.id_client')
                      ->join('master_jabatan', 'master_jabatan.id', '=', 'master_pegawai.id_jabatan')
                      ->select('hr_pkwt.tanggal_masuk_gmt', 'hr_pkwt.tanggal_masuk_client', 'master_pegawai.nip', 'master_pegawai.no_rekening', 'master_pegawai.nama', 'master_client.nama_client', 'master_client.kode_client', 'master_client.token', 'master_client_cabang.nama_cabang','master_jabatan.nama_jabatan', 'master_pegawai.no_ktp', 'master_pegawai.tanggal_lahir', 'master_pegawai.no_kk', 'master_pegawai.alamat', 'master_pegawai.no_telp', 'master_pegawai.jenis_kelamin', 'spv.nama as spv')
                      ->where('master_client.id', $idClient)
                      ->where('hr_pkwt.status_pkwt', '=', 1)
                      ->where('hr_pkwt.tanggal_akhir_pkwt', '>', $sysDate)
                      ->orderBy('spv.nama')
                      ->orderBy('hr_pkwt.tanggal_masuk_gmt', 'ASC')
                      ->paginate(10);

      return view('pages.laporan.laporanpegawai', compact('getClient', 'idClient', 'proses'));
    }

    public function downloadExcel($id)
    {
      $idClient = $id;

      $sysDate = date('Y-m-d');

      $proses = HrPkwt::join('master_pegawai as spv', 'spv.id', '=', 'hr_pkwt.id_kelompok_jabatan')
                      ->join('master_pegawai', 'master_pegawai.id', '=', 'hr_pkwt.id_pegawai')
                      ->join('master_client_cabang', 'master_client_cabang.id', '=', 'hr_pkwt.id_cabang_client')
                      ->join('master_client', 'master_client.id', '=', 'master_client_cabang.id_client')
                      ->join('master_jabatan', 'master_jabatan.id', '=', 'master_pegawai.id_jabatan')
                      ->select('master_pegawai.nip', 'master_pegawai.no_rekening', 'master_pegawai.nama', 'master_client_cabang.nama_cabang', 'spv.nama as spv', 'master_jabatan.nama_jabatan', 'master_pegawai.no_ktp', 'master_pegawai.tanggal_lahir', 'master_pegawai.no_kk', 'master_pegawai.alamat', 'master_pegawai.no_telp', 'master_pegawai.jenis_kelamin', 'hr_pkwt.tanggal_masuk_gmt', 'hr_pkwt.tanggal_masuk_client')
                      ->where('master_client.id', $idClient)
                      ->where('hr_pkwt.status_pkwt', '=', 1)
                      ->where('hr_pkwt.tanggal_akhir_pkwt', '>', $sysDate)
                      ->orderBy('spv.nama')
                      ->orderBy('hr_pkwt.tanggal_masuk_gmt', 'ASC')
                      ->get()
                      ->toArray();

      $spv  = MasterPegawai::join('hr_pkwt', 'hr_pkwt.id_kelompok_jabatan', '=', 'master_pegawai.id')
                            ->select('hr_pkwt.id_kelompok_jabatan', 'master_pegawai.nama')
                            ->where('hr_pkwt.status_pkwt', 1)
                            ->distinct()
                            ->get();

      return Excel::create('Export Data Pegawai - '.$sysDate, function($excel) use($proses, $spv){
        $excel->sheet('Data Pegawai', function($sheet) use ($proses)
        {
          $sheet->fromArray($proses, null, 'A3', true);
          $sheet->mergeCells('A1:N2');
          $sheet->row(1, array('PT. GANDA MADY INDOTAMA - Data Personnel Pegawai '));
          $sheet->row(3, array('NIP','No Rekening','Nama','Departemen', 'Kelompok Jabatan', 'Jabatan', 'No KTP', 'Tanggal Lahir', 'No KK', 'Alamat', 'No Tlp', 'Jenis Kelamin', 'Tanggal Masuk GMT', 'Tanggal Masuk Client'));
          $sheet->cell('A1:N3', function($cell){
            $cell->setFontSize(12);
            $cell->setFontWeight('bold');
            $cell->setAlignment('center');
            $cell->setValignment('center');
          });
          $sheet->setAutoFilter('A3:N3');
          $sheet->setAllBorders('thin');
          $sheet->setFreeze('A4');
        });
      })->download('xlsx');
    }

    public function reportforclient($kode_client, $token)
    {

      $cekToken = MasterClient::where('token', $token)->where('kode_client', $kode_client)->first();

      if($cekToken == null)
      {
        return view('errors.000');
      }

      $idClient = MasterClient::select('id')->where('kode_client', $kode_client)->get();

      $getClient  = MasterClient::get();

      $sysDate = date('Y-m-d');
      $proses = HrPkwt::join('master_pegawai as spv', 'spv.id', '=', 'hr_pkwt.id_kelompok_jabatan')
                      ->join('master_pegawai', 'master_pegawai.id', '=', 'hr_pkwt.id_pegawai')
                      ->join('master_client_cabang', 'master_client_cabang.id', '=', 'hr_pkwt.id_cabang_client')
                      ->join('master_client', 'master_client.id', '=', 'master_client_cabang.id_client')
                      ->join('master_jabatan', 'master_jabatan.id', '=', 'master_pegawai.id_jabatan')
                      ->select('hr_pkwt.tanggal_masuk_gmt', 'hr_pkwt.tanggal_masuk_client', 'master_pegawai.nip', 'master_pegawai.no_rekening', 'master_pegawai.nama', 'master_client.nama_client', 'master_client_cabang.nama_cabang','master_jabatan.nama_jabatan', 'master_pegawai.no_ktp', 'master_pegawai.tanggal_lahir', 'master_pegawai.no_kk', 'master_pegawai.alamat', 'master_pegawai.no_telp', 'master_pegawai.jenis_kelamin', 'spv.nama as spv')
                      ->where('master_client.id', $idClient[0]->id)
                      ->where('hr_pkwt.status_pkwt', '=', 1)
                      ->where('hr_pkwt.tanggal_akhir_pkwt', '>', $sysDate)
                      ->orderBy('spv.nama')
                      ->orderBy('hr_pkwt.tanggal_masuk_gmt', 'ASC')
                      ->paginate(10);

      return view('pages.laporan.laporanpegawaiforclient', compact('getClient', 'idClient', 'proses'));
    }
}
