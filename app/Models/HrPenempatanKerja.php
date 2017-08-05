<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrPenempatanKerja extends Model
{
    protected $table = 'hr_penempatan_kerja';

    protected $fillable = ['id_departemen','id_pegawai','status'];

    
}
