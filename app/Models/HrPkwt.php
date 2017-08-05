<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrPkwt extends Model
{
    protected $table = 'hr_pkwt';

    protected $fillable = ['id_pegawai','id_cabang_client','id_kelompok_jabatan','tanggal_masuk_gmt','tanggal_masuk_client','status_pkwt','tanggal_awal_pkwt','tanggal_akhir_pkwt','status_karyawan_pkwt','flag_terminate'];

    public function pegawai()
    {
      return $this->belongsTo('App\Models\MasterPegawai', 'id_pegawai');
    }

    public function clientCabang()
    {
      return $this->belongsTo('App\Models\MasterClientCabang', 'id_cabang_client');
    }
}
