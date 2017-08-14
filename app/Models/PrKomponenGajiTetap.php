<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrKomponenGajiTetap extends Model
{
    protected $table = 'pr_komponen_gaji_tetap';

    protected $fillable = ['id_komponen_gaji','id_cabang_client','keterangan','komgaj_tetap_dibayarkan','flag_status'];

    public function komponenGaji()
    {
      return $this->belongsTo('App\Models\MasterKomponenGaji', 'id_komponen_gaji');
    }

    public function clientCabang()
    {
      return $this->belongsTo('App\Models\MasterClientCabang', 'id_cabang_client');
    }
}
