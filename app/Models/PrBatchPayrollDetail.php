<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrBatchPayrollDetail extends Model
{
    protected $table = 'pr_batch_payroll_detail';

    protected $fillable = ['id_batch_payroll','id_pegawai','workday','abstain','sick_leave','permissed_leave', 'tipe_pembayaran'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }

    public function batchPayroll()
    {
      return $this->belongsTo('App\Models\PrBatchPayroll', 'id_batch_payroll');
    }
}
