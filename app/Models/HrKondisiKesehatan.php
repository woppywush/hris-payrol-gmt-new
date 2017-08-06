<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrKondisiKesehatan extends Model
{
    protected $table = 'hr_kondisi_kesehatan';

    protected $fillable = ['id_pegawai','tinggi_badan','berat_badan','warna_rambut','warna_mata','berkacamata','merokok'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
