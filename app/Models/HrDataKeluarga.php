<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrDataKeluarga extends Model
{
    protected $table = 'hr_data_keluarga';

    protected $fillable = ['id_pegawai','nama_keluarga','hubungan_keluarga','tanggal_lahir_keluarga','alamat_keluarga','pekerjaan_keluarga','jenis_kelamin_keluarga'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
