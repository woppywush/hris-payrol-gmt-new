<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrDokumenPegawai extends Model
{
    protected $table = 'hr_dokumen_pegawai';

    protected $fillable = ['id_pegawai','nama_dokumen','file_dokumen'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
