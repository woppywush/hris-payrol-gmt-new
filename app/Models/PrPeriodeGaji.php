<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrPeriodeGaji extends Model
{
    protected $table = 'pr_periode_gaji';

    protected $fillable = ['tanggal','keterangan'];

    public function detail_periode_gaji()
    {
      return $this->hasMany('App\Models\PrPeriodeGajiDetail');
    }

    public function batch_thr()
    {
      return $this->hasMany('App\Models\PrBatchThr');
    }


}
