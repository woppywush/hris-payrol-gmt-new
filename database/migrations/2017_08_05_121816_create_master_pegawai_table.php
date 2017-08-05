<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_pegawai', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_jabatan')->unsigned();
          $table->integer('id_bank')->unsigned();
          $table->string('nip');
          $table->string('nip_lama');
          $table->string('no_ktp');
          $table->string('no_kk');
          $table->string('no_npwp');
          $table->string('nama');
          $table->date('tanggal_lahir');
          $table->string('jenis_kelamin', 1);
          $table->string('email');
          $table->text('alamat');
          $table->string('agama');
          $table->string('no_telp');
          $table->string('status_pajak');
          $table->string('kewarganegaraan');
          $table->string('bpjs_kesehatan');
          $table->string('bpjs_ketenagakerjaan');
          $table->string('no_rekening');
          $table->string('nama_darurat');
          $table->string('alamat_darurat');
          $table->string('hubungan_darurat');
          $table->string('telepon_darurat');
          $table->string('gaji_pokok');
          $table->integer('workday')->unsigned();
          $table->integer('status')->unsigned();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
