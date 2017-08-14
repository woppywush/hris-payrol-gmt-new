<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrBatchProcessedDetail extends Model
{
    protected $table = 'pr_batch_processed_detail';

    protected $fillable = ['id_pegawai','id_batch_processed','nip','nama','jabatan','hari_normal','abstain','sick_leave','permissed_leave','hari_kerja','penerimaan_tetap','penerimaan_variable','potongan_tetap','potongan_variable','total'];


    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }

    public function batchProcessed()
    {
      return $this->belongsTo('App\Models\PrBatchProcessed', 'id_batch_processed');
    }
}
