<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrDataPeringatan extends Model
{
    protected $table = 'hr_data_peringatan';

    protected $fillable = ['id_pegawai','tanggal_peringatan','jenis_peringatan','keterangan_peringatan','dokumen_peringatan'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
