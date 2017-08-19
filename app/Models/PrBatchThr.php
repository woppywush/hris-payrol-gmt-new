<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrBatchThr extends Model
{
    protected $table = 'pr_batch_thr';

    protected $fillable = ['id_periode_gaji','tanggal_generate','bulan_awal','bulan_akhir','diff_bulan','flag_processed'];

    public function periode()
    {
      return $this->belongsTo('App\Models\PrPeriodeGaji', 'id_periode_gaji');
    }
}
