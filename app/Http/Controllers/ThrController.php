<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MasterPegawai;
use App\Models\PrPeriodeGaji;
use App\Models\PrBatchThr;
use App\Models\PrBatchTHRDetail;
use App\Models\PrPeriodeGajiDetail;
use App\Models\HrPkwt;

use Datatables;
use Carbon\Carbon;
use DB;
use Excel;

class ThrController extends Controller
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
      $getperiode = PrPeriodeGaji::all();
      $getbatchthr = PrBatchThr::all();

      return view('pages.thr.index')
        ->with('getbatchthr', $getbatchthr)
        ->with('getperiode', $getperiode);
    }

    public function store(Request $request)
    {
      $bulanawalexp = explode('-', $request->bulan_awal);
      $bulanakhirexp = explode('-', $request->bulan_akhir);

      $dt1 = Carbon::create($bulanawalexp[1], $bulanawalexp[0], 1);
      $dt2 = Carbon::create($bulanakhirexp[1], $bulanakhirexp[0], 1);

      $diff = $dt1->diffInMonths($dt2);

      $thr = new PrBatchThr;
      $thr->id_periode_gaji = $request->periode;
      $thr->tanggal_generate = date('Y-m-d');
      $thr->bulan_awal = $request->bulan_awal;
      $thr->bulan_akhir = $request->bulan_akhir;
      $thr->diff_bulan = $diff+1;
      $thr->flag_processed = 0;
      $thr->save();

      $getpegawai = PrPeriodeGajiDetail::where('id_periode_gaji', $request->periode)->get();
      $getpkwt = HrPkwt::orderby('tanggal_masuk_gmt')->get();
      $getgajipokok = MasterPegawai::select('id', 'gaji_pokok')->get();


      foreach ($getpegawai as $key) {

        $tanggal_masuk_gmt = null;
        foreach ($getpkwt as $keys) {
          if ($keys->id_pegawai==$key->id_pegawai) {
            $tanggal_masuk_gmt = $keys->tanggal_masuk_gmt;
            break;
          }
        }

        $tanggalmasukexp = explode('-', $tanggal_masuk_gmt);
        $dt3 = Carbon::create($tanggalmasukexp[0], $tanggalmasukexp[1], $tanggalmasukexp[2]);
        $selisihbulan = $dt3->diffInMonths($dt2);

        $nilai_prorate = 0;
        $nilai_thr = 0;
        $gajipokok = 0;

        foreach ($getgajipokok as $keys) {
          if ($keys->id==$key->id_pegawai) {
            if (!is_null($keys->gaji_pokok)) {
              $gajipokok = $keys->gaji_pokok;
              break;
            }
          }
        }

        if ($gajipokok!=0) {
          $nilai_prorate = round($gajipokok / 12);
          if ($selisihbulan>=12) {
            $nilai_thr = $gajipokok;
          } else {
            $nilai_thr = $nilai_prorate * $selisihbulan;
          }
        }

        $detail_thr = new PrBatchThrDetail;
        $detail_thr->id_batch_thr = $thr->id;
        $detail_thr->id_pegawai = $key->id_pegawai;
        $detail_thr->bulan_kerja = $selisihbulan;
        $detail_thr->nilai_prorate = $nilai_prorate;
        $detail_thr->nilai_thr = $nilai_thr;
        $detail_thr->save();
      }

      return redirect()->route('thr.index')->with('message', 'Berhasil men-generate batch THR.');

    }

    public function detail($id)
    {
      $getdata = PrBatchThr::select('tanggal_generate', 'bulan_awal', 'bulan_akhir', 'diff_bulan', 'tanggal', 'flag_processed')
        ->join('pr_periode_gaji', 'pr_periode_gaji.id', '=', 'pr_batch_thr.id_periode_gaji')
        ->where('pr_batch_thr.id', $id)->first();

      $getdetail = PrBatchThrDetail::where('id_batch_thr', $id)->get();

      $jumlahthr = 0;
      foreach ($getdetail as $key) {
        $jumlahthr = $jumlahthr + $key->nilai_thr;
      }

      setlocale(LC_TIME, 'id_ID.utf8');
      Carbon::setLocale('id');

      $bulan_awal = explode('-', $getdata->bulan_awal);
      $dt1 = Carbon::create($bulan_awal[1], $bulan_awal[0], 1);

      $bulan_akhir = explode('-', $getdata->bulan_akhir);
      $dt2 = Carbon::create($bulan_akhir[1], $bulan_akhir[0], 1);

      $monthawal = $dt1->formatLocalized('%B');
      $monthakhir = $dt2->formatLocalized('%B');

      $data["periode"] = $getdata->tanggal;
      $data["tanggal_generate"] = $getdata->tanggal_generate;
      $data["bulan_awal"] = $monthawal.", ".$bulan_awal[1];
      $data["bulan_akhir"] = $monthakhir.", ".$bulan_akhir[1];
      $data["jumlah_hitung"] = $getdata->diff_bulan;
      $data["jumlah_pegawai"] = count($getdetail);
      $data["total_pengeluaran"] = $jumlahthr;
      $data["status"] = $getdata->flag_processed;

      return view('pages.thr.detail-thr')
        ->with('summarydata', $data)
        ->with('id_batch_thr', $id);
    }

    public function getdata($id)
    {
      $pegawai = MasterPegawai::select('nip', 'nama', 'bulan_kerja', 'nilai_thr', 'pr_batch_thr.flag_processed')
        ->join('pr_batch_thr_detail', 'pr_batch_thr_detail.id_pegawai', '=', 'master_pegawai.id')
        ->join('pr_batch_thr', 'pr_batch_thr.id', '=', 'pr_batch_thr_detail.id_batch_thr')
        ->where('pr_batch_thr.id', $id)
        ->get();

      return Datatables::of($pegawai)
        ->editColumn('bulan_kerja', function($peg){
          if ($peg->flag_processed==1) {
            if ($peg->bulan_kerja<12) {
              return "<span class='badge bg-default'>$peg->bulan_kerja Bulan</span>";
            } else {
              return "<span class='badge bg-default'>12 Bulan</span>";
            }
          } else {
            if ($peg->bulan_kerja<12) {
              return "<span class='badge bg-red'>$peg->bulan_kerja Bulan</span>";
            } else {
              return "<span class='badge bg-green'>12 Bulan</span>";
            }
          }
        })
        ->editColumn('nilai_thr', function($peg){
          return "Rp ".number_format($peg->nilai_thr, 0, 0, '.').",-";
        })
        ->addColumn('action', function($user){
          if ($user->flag_processed==1) {
            return '<span data-toggle="tooltip" title="Edit Hitungan Bulan Kerja"> <a href="" class="btn btn-xs btn-default disabled editgaji" data-toggle="modal" data-target="#myModalEditGaji" data-value="'.$user->id.'"><i class="fa fa-edit"></i></a></span> <span data-toggle="tooltip" title="Hapus Dari Periode"> <a href="" class="btn btn-xs btn-default disabled hapus" data-toggle="modal" data-target="#myModal" data-value="'.$user->id_periode_gaji.'"><i class="fa fa-close"></i></a></span>';
          } else {
            return '<span data-toggle="tooltip" title="Edit Hitungan Bulan Kerja"> <a href="" class="btn btn-xs btn-warning editgaji" data-toggle="modal" data-target="#myModalEditGaji" data-value="'.$user->id.'"><i class="fa fa-edit"></i></a></span> <span data-toggle="tooltip" title="Hapus Dari Periode"> <a href="" class="btn btn-xs btn-danger hapus" data-toggle="modal" data-target="#myModal" data-value="'.$user->id_periode_gaji.'"><i class="fa fa-close"></i></a></span>';
          }
        })
        ->removeColumn('flag_processed')
        ->make();
    }

    public function process($id)
    {
      $get = PrBatchThr::find($id);
      $get->flag_processed = 1;
      $get->save();

      return redirect()->route('thr.detail', $id)->with('message', 'Berhasil memproses batch THR.');
    }

    public function destroy($id)
    {
      $deletedetail = PrBatchThrDetail::where('id_batch_thr', $id)->delete();
      $deletethr = PrBatchThr::find($id)->delete();

      return redirect()->route('thr.index')->with('message', 'Berhasil menghapus batch THR.');
    }

    public function bind($id)
    {
      $get = PrBatchThr::join('periode_gaji', 'periode_gaji.id', '=', 'batch_thr.id_periode_gaji')
        ->where('batch_thr.id', $id)
        ->first();

      return $get;
    }

    public function update(Request $request, $id)
    {
      $bulanawalexp = explode('-', $request->bulan_awal);
      $bulanakhirexp = explode('-', $request->bulan_akhir);

      $dt1 = Carbon::create($bulanawalexp[1], $bulanawalexp[0], 1);
      $dt2 = Carbon::create($bulanakhirexp[1], $bulanakhirexp[0], 1);

      $diff = $dt1->diffInMonths($dt2);

      $thr = PrBatchThr::find($id);
      $thr->id_periode_gaji = $request->periode;
      $thr->bulan_awal = $request->bulan_awal;
      $thr->bulan_akhir = $request->bulan_akhir;
      $thr->diff_bulan = $diff+1;
      $thr->flag_processed = 0;
      $thr->save();

      // delete data dari detail batch terkait
      $cleardata = PrBatchThrDetail::where('id_batch_thr', $id)->delete();
      // end of delete data dari detail batch terkait

      $getpegawai = PrPeriodeGajiDetail::where('id_periode_gaji', $request->periode)->get();
      $getpkwt = HrPkwt::orderby('tanggal_masuk_gmt')->get();
      $getgajipokok = MasterPegawai::select('id', 'gaji_pokok')->get();


      foreach ($getpegawai as $key) {

        $tanggal_masuk_gmt = null;
        foreach ($getpkwt as $keys) {
          if ($keys->id_pegawai==$key->id_pegawai) {
            $tanggal_masuk_gmt = $keys->tanggal_masuk_gmt;
            break;
          }
        }

        $tanggalmasukexp = explode('-', $tanggal_masuk_gmt);
        $dt3 = Carbon::create($tanggalmasukexp[0], $tanggalmasukexp[1], $tanggalmasukexp[2]);
        $selisihbulan = $dt3->diffInMonths($dt2);

        $nilai_prorate = 0;
        $nilai_thr = 0;
        $gajipokok = 0;

        foreach ($getgajipokok as $keys) {
          if ($keys->id==$key->id_pegawai) {
            if (!is_null($keys->gaji_pokok)) {
              $gajipokok = $keys->gaji_pokok;
              break;
            }
          }
        }

        if ($gajipokok!=0) {
          $nilai_prorate = round($gajipokok / 12);
          if ($selisihbulan>=12) {
            $nilai_thr = $gajipokok;
          } else {
            $nilai_thr = $nilai_prorate * $selisihbulan;
          }
        }

        $detail_thr = new PrBatchThrDetail;
        $detail_thr->id_batch_thr = $thr->id;
        $detail_thr->id_pegawai = $key->id_pegawai;
        $detail_thr->bulan_kerja = $selisihbulan;
        $detail_thr->nilai_prorate = $nilai_prorate;
        $detail_thr->nilai_thr = $nilai_thr;
        $detail_thr->save();
      }

      return redirect()->route('thr.index')->with('message', 'Berhasil men-generate batch THR.');
    }

    public function prosesThr($id)
    {
        $pegawai = MasterPegawai::select('nip', 'nama', 'bulan_kerja', 'nilai_thr', 'pr_batch_thr.flag_processed')
          ->join('pr_batch_thr_detail', 'pr_batch_thr_detail.id_pegawai', '=', 'master_pegawai.id')
          ->join('pr_batch_thr', 'pr_batch_thr.id', '=', 'pr_batch_thr_detail.id_batch_thr')
          ->where('pr_batch_thr.id', $id)
          ->get();

        $batchThr = PrBatchThr::find($id);

        Excel::create('Proses Thr Periode -'.$batchThr->bulan_awal.' s-d '.$batchThr->bulan_akhir, function($excel) use($pegawai,$batchThr) {
            $excel->sheet('All Thr', function($sheet) use($pegawai,$batchThr) {
              $sheet->loadView('pages.laporanPayroll.thrProses')
                      ->with('pegawai', $pegawai)
                      ->with('batchThr', $batchThr);
            });
        })->download('xlsx');

        return response()->json(['success' => 200]);
    }
}
