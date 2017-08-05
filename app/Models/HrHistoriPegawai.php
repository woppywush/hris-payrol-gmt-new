<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrHistoriPegawai extends Model
{
    protected $table = 'hr_histori_pegawai';

    protected $fillable = ['id_pegawai','keterangan'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
