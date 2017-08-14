<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrPeriodeGaji extends Model
{
    protected $table = 'pr_periode_gaji';

    protected $fillable = ['tanggal','keterangan'];

    
}
