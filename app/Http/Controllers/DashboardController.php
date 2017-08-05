<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Auth;
use DB;
use App\Models\MasterUser;
use App\Models\HrPkwt;
use App\Models\MasterPegawai;
use App\Models\MasterClient;
use App\Models\BatchPayroll;
use App\Models\BatchProcessed;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('isAdmin');
    }

    public function gotodashboard()
    {
      if (Auth::user()->level==1) {

        $jumlah_pegawai = MasterPegawai::where('status' , '1')->count();
        $jumlah_client = MasterClient::count();
        $jumlah_pkwt_expired = HrPkwt::where('tanggal_akhir_pkwt', '<', Carbon::now())->count();
        $jumlah_pkwt = HrPkwt::all();

        $jumlah_pkwt_menuju_expired=0;
        foreach ($jumlah_pkwt as $key) {
          $tgl = explode('-', $key->tanggal_akhir_pkwt);
          $tglakhir = Carbon::createFromDate($tgl[0], $tgl[1], $tgl[2]);
          $now = gmdate("Y-m-d", time()+60*60*7);
          $tglskrg = explode('-', $now);
          $result = Carbon::createFromDate($tglskrg[0],$tglskrg[1],$tglskrg[2])->diffInDays($tglakhir, false);
          if($result > 0 && $result < 30) {
            $jumlah_pkwt_menuju_expired++;
          }
        }

        return view('pages.dashboard.index', compact('jumlah_pegawai', 'jumlah_client', 'jumlah_pkwt_expired', 'jumlah_pkwt_menuju_expired'));
      } else if (Auth::user()->level==2) {

        $jumlah_pegawai = MasterPegawai::where('status' , '1')->count();
        $jumlah_client = MasterClient::count();
        $jumlah_pkwt_expired = HrPkwt::where('tanggal_akhir_pkwt', '<', Carbon::now())->count();
        $jumlah_pkwt = HrPkwt::all();

        $jumlah_pkwt_menuju_expired=0;
        foreach ($jumlah_pkwt as $key) {
          $tgl = explode('-', $key->tanggal_akhir_pkwt);
          $tglakhir = Carbon::createFromDate($tgl[0], $tgl[1], $tgl[2]);
          $now = gmdate("Y-m-d", time()+60*60*7);
          $tglskrg = explode('-', $now);
          $result = Carbon::createFromDate($tglskrg[0],$tglskrg[1],$tglskrg[2])->diffInDays($tglakhir, false);
          if($result > 0 && $result < 30) {
            $jumlah_pkwt_menuju_expired++;
          }
        }

        $batchprocessed = BatchPayroll::
          select('batch_payroll.id', 'periode_gaji.tanggal', 'batch_processed.tanggal_cutoff_awal', 'batch_processed.tanggal_cutoff_akhir', 'batch_processed.total_pegawai', 'batch_processed.total_pengeluaran', 'batch_payroll.flag_processed')
          ->leftjoin('batch_processed', 'batch_payroll.id', '=', 'batch_processed.id_batch_payroll')
          ->join('periode_gaji', 'batch_processed.id_periode', '=', 'periode_gaji.id')
          ->orderby('batch_processed.id', 'desc')
          ->get();

        $getclient = MasterClient::
          select('master_client.id', 'master_client.nama_client', DB::RAW('count(*) as jumlah_cabang'))
          ->join('cabang_client', 'master_client.id', '=', 'cabang_client.id_client')
          ->groupby('cabang_client.id_client')
          ->get();

        return view('pages.dashboard.index')
          ->with('jumlah_pegawai', $jumlah_pegawai)
          ->with('jumlah_client', $jumlah_client)
          ->with('jumlah_pkwt_expired', $jumlah_pkwt_expired)
          ->with('batchprocessed', $batchprocessed)
          ->with('getclient', $getclient)
          ->with('jumlah_pkwt_menuju_expired', $jumlah_pkwt_menuju_expired);
      }else{
        $jumlah_pegawai = MasterPegawai::where('status' , '1')->count();
        $jumlah_client = MasterClient::count();
        $jumlah_pkwt_expired = HrPkwt::where('tanggal_akhir_pkwt', '<', Carbon::now())->count();
        $jumlah_pkwt = HrPkwt::all();

        $jumlah_pkwt_menuju_expired=0;
        foreach ($jumlah_pkwt as $key) {
          $tgl = explode('-', $key->tanggal_akhir_pkwt);
          $tglakhir = Carbon::createFromDate($tgl[0], $tgl[1], $tgl[2]);
          $now = gmdate("Y-m-d", time()+60*60*7);
          $tglskrg = explode('-', $now);
          $result = Carbon::createFromDate($tglskrg[0],$tglskrg[1],$tglskrg[2])->diffInDays($tglakhir, false);
          if($result > 0 && $result < 30) {
            $jumlah_pkwt_menuju_expired++;
          }
        }

        $batchprocessed = BatchPayroll::
          select('batch_payroll.id', 'periode_gaji.tanggal', 'batch_processed.tanggal_cutoff_awal', 'batch_processed.tanggal_cutoff_akhir', 'batch_processed.total_pegawai', 'batch_processed.total_pengeluaran', 'batch_payroll.flag_processed')
          ->leftjoin('batch_processed', 'batch_payroll.id', '=', 'batch_processed.id_batch_payroll')
          ->join('periode_gaji', 'batch_processed.id_periode', '=', 'periode_gaji.id')
          ->orderby('batch_processed.id', 'desc')
          ->get();

        $getclient = MasterClient::
          select('master_client.id', 'master_client.nama_client', DB::RAW('count(*) as jumlah_cabang'))
          ->join('cabang_client', 'master_client.id', '=', 'cabang_client.id_client')
          ->groupby('cabang_client.id_client')
          ->get();

        return view('pages.dashboard.index')
          ->with('jumlah_pegawai', $jumlah_pegawai)
          ->with('jumlah_client', $jumlah_client)
          ->with('jumlah_pkwt_expired', $jumlah_pkwt_expired)
          ->with('batchprocessed', $batchprocessed)
          ->with('getclient', $getclient)
          ->with('jumlah_pkwt_menuju_expired', $jumlah_pkwt_menuju_expired);
      }
    }
}
