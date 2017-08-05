<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrPengalamanKerja extends Model
{
    protected $table = 'hr_pengalaman_kerja';

    protected $fillable = ['id_pegawai','nama_perusahaan','posisi_perusahaan','tahun_awal_kerja','tahun_akhir_kerja'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
