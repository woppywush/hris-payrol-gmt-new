<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrRapelGajiDetail extends Model
{
    protected $table = 'pr_rapel_gaji_detail';

    protected $fillable = ['id_pegawai','id_rapel_gaji','jml_bulan_selisih','nilai_rapel'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }

    public function rapelGaji()
    {
      return $this->belongsTo('App\Models\PrRapelGaji', 'id_rapel_gaji');
    }
}
