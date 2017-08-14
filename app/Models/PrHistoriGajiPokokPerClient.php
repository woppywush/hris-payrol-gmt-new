<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrHistoriGajiPokokPerClient extends Model
{
    protected $table = 'pr_histori_gaji_pokok_per_client';

    protected $fillable = ['id_client','id_cabang_client','tanggal_penyesuaian','nilai','flag_rapel_gaji'];

    public function client()
    {
      return $this->belongsTo('App\Models\MasterClient', 'id_client');
    }

    public function clientCabang()
    {
      return $this->belongsTo('App\Models\MasterClientCabang', 'id_cabang_client');
    }
}
