<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrKomponenGajiDetail extends Model
{
    protected $table = 'pr_komponen_gaji_detail';

    protected $fillable = ['id_batch_payroll_detail','id_komponen_gaji','nilai'];

    public function batchPayrollDetail()
    {
      return $this->belongsTo('App\Models\PrBatchPayrollDetail', 'id_batch_payroll_detail');
    }

    public function komponenGaji()
    {
      return $this->belongsTo('App\Models\MasterKomponenGaji', 'id_komponen_gaji');
    }
}
