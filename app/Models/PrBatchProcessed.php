<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrBatchProcessed extends Model
{
    protected $table = 'pr_batch_processed';

    protected $fillable = ['id_batch_payroll','id_periode','tanggal_proses_payroll','tanggal_cutoff_awal','tanggal_cutoff_akhir','total_pegawai','total_penerimaan_gaji','total_potongan_gaji','total_pengeluaran'];

    public function batchPayroll()
    {
      return $this->belongsTo('App\Models\PrBatchPayroll', 'id_batch_payroll');
    }

    public function periode()
    {
      # code...
    }
}
