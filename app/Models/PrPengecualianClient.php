<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrPengecualianClient extends Model
{
    protected $table = 'pr_pengecualian_client';

    protected $fillable = ['id_pegawai','id_cabang_client','flag_status'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }

    public function clientCabang()
    {
      return $this->belongsTo('App\Models\MasterClientCabang', 'id_cabang_client');
    }
}
