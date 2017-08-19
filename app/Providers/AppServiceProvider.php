<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\HrPkwt;

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

        $checkPkwtAktiv = HrPkwt::where('tanggal_akhir_pkwt', '<=', $today)->where('status_pkwt', 1)->update(['status_pkwt' => 0]);
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
