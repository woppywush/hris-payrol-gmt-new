<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrBatchPayroll extends Model
{
    protected $table = 'pr_batch_payroll';

    protected $fillable = ['id_periode_gaji','tanggal_proses','tanggal_proses_akhir','flag_processed'];

    public function periode_gaji()
    {
      
    }
}
