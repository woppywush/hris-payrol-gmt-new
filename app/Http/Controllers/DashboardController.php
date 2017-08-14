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
use App\Models\PrBatchPayroll;
use App\Models\PrBatchProcessed;

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

        $batchprocessed = PrBatchPayroll::
          select('pr_batch_payroll.id', 'pr_periode_gaji.tanggal', 'pr_batch_processed.tanggal_cutoff_awal', 'pr_batch_processed.tanggal_cutoff_akhir', 'pr_batch_processed.total_pegawai', 'pr_batch_processed.total_pengeluaran', 'pr_batch_payroll.flag_processed')
          ->leftjoin('pr_batch_processed', 'pr_batch_payroll.id', '=', 'pr_batch_processed.id_batch_payroll')
          ->join('pr_periode_gaji', 'pr_batch_processed.id_periode', '=', 'pr_periode_gaji.id')
          ->orderby('pr_batch_processed.id', 'desc')
          ->get();

        $getclient = MasterClient::
          select('master_client.id', 'master_client.nama_client', DB::RAW('count(*) as jumlah_cabang'))
          ->join('master_client_cabang', 'master_client.id', '=', 'master_client_cabang.id_client')
          ->groupby('master_client_cabang.id_client')
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

        $batchprocessed = PrBatchPayroll::
          select('pr_batch_payroll.id', 'pr_periode_gaji.tanggal', 'pr_batch_processed.tanggal_cutoff_awal', 'pr_batch_processed.tanggal_cutoff_akhir', 'pr_batch_processed.total_pegawai', 'pr_batch_processed.total_pengeluaran', 'pr_batch_payroll.flag_processed')
          ->leftjoin('pr_batch_processed', 'pr_batch_payroll.id', '=', 'pr_batch_processed.id_batch_payroll')
          ->join('pr_periode_gaji', 'pr_batch_processed.id_periode', '=', 'pr_periode_gaji.id')
          ->orderby('pr_batch_processed.id', 'desc')
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
