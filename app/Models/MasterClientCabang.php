<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterClientCabang extends Model
{
    protected $table = 'master_client_cabang';

    protected $fillable = ['id_client','kode_cabang','nama_cabang','alamat_cabang'];


    public function client()
    {
      return $this->belongsTo('App\Models\MasterClient', 'id_client');
    }
}
