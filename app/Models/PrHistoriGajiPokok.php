<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrHistoriGajiPokok extends Model
{
    protected $table = 'pr_histori_gaji_pokok';

    protected $fillable = ['gaji_pokok','periode_tahun','keterangan','id_pegawai','id_cabang_client','flag_status'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }

    public function clientCabang()
    {
      return $this->belongsTo('App\Models\MasterClientCabang', 'id_cabang_client');
    }
}
