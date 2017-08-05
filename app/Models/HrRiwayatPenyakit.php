<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrRiwayatPenyakit extends Model
{
    protected $table = 'hr_riwayat_penyakit';

    protected $fillable = ['id_pegawai','nama_penyakit','keterangan_penyakit'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
