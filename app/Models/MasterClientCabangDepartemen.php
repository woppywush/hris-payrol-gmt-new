<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterClientCabangDepartemen extends Model
{
    protected $table = 'master_client_cabang_departemen';

    protected $fillable = ['id_cabang','kode_departemen','nama_departemen'];

    public function cabang()
    {
      return $this->belongsTo('App\Models\MasterClientCabang', 'id_cabang');
    }
}
