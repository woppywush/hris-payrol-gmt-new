<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrBatchThrDetail extends Model
{
    protected $table = 'pr_batch_thr_detail';

    protected $fillable = ['id_batch_thr','id_pegawai','bulan_kerja','nilai_prorate','nilai_thr'];

    public function batchThr()
    {
      return $this->belongsTo('App\Models\PrBatchThr', 'id_batch_thr');
    }
}
