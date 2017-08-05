<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrBahasaAsing extends Model
{
    protected $table = 'hr_bahasa_asing';

    protected $fillable = ['id_pegawai','bahasa','berbicara','menulis','mengerti'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }
}
