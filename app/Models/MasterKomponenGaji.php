<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKomponenGaji extends Model
{
    protected $table = 'master_komponen_gaji';

    protected $fillable = ['nama_komponen','tipe_komponen','periode_perhitungan','flag_status','tipe_komponen_gaji'];
}
