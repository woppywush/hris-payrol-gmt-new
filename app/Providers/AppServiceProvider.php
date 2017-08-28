<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\HrPkwt;
use App\Models\MasterPegawai;

use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $today = date('Y-m-d');

        $dateTraining = Carbon::now()->toDateTimeString();

        $checkPkwtAktiv = HrPkwt::where('tanggal_akhir_pkwt', '<=', $today)->where('status_pkwt', 1)->update(['status_pkwt' => 0]);

        $checkTraining = MasterPegawai::where('tanggal_training', '>=', Carbon::now()->subYears(1)->toDateTimeString())->update(['jam_training' => 0],['tanggal_training' => $dateTraining]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
