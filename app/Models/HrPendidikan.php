<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrPendidikan extends Model
{
    protected $table = 'hr_pendidikan';

    protected $fillable = ['id_pegawai','jenjang_pendidikan','institusi_pendidikan','tahun_masuk_pendidikan','tahun_lulus_pendidikan','gelar_akademik'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
