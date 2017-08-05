<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrKeahlianKomputer extends Model
{
    protected $table = 'hr_keahlian_komputer';

    protected $fillable = ['id_pegawai','nama_program','nilai_komputer'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
