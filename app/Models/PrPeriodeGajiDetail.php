<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrPeriodeGajiDetail extends Model
{
    protected $table = 'pr_periode_gaji_detail';

    protected $fillable = ['id_periode_gaji','id_pegawai'];

    public function periodeGaji()
    {
      return $this->belongsTo('App\Models\PrPeriodeGaji', 'id_periode_gaji');
    }

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
