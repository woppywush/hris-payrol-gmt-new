<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrBpjs extends Model
{
    protected $table = 'pr_bpjs';

    protected $fillable = ['id_bpjs','id_cabang_client','bpjs_dibayarkan','keterangan'];

    public function clientCabang()
    {
      return $this->belongsTo('App\Models\MasterClientCabang', 'id_cabang_client');
    }

    public function bpjs()
    {
      return $this->belongsTo('App\Models\MasterKomponenGaji', 'id_bpjs');
    }
}
