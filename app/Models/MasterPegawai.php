<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPegawai extends Model
{
    protected $table = 'master_pegawai';

    protected $fillable = ['id_jabatan','id_bank','nip','nip_lama','no_ktp','no_kk','no_npwp','nama','tanggal_lahir','jenis_kelamin','email','alamat','agama','no_telp','status_pajak','kewarganegaraan','bpjs_kesehatan','bpjs_ketenagakerjaan','no_rekening','nama_darurat','alamat_darurat','hubungan_darurat','telepon_darurat','gaji_pokok','workday','status','jam_training','tanggal_training'];


    public function jabatan()
    {
      return $this->belongsTo('App\Models\MasterJabatan', 'id_jabatan');
    }

    public function bank()
    {
      return $this->belongsTo('App\Models\MasterBank', 'id_bank');
    }
}
