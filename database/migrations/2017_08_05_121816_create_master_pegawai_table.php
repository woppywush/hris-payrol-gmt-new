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
          $table->integer('id_bank')->unsigned()->nullable();
          $table->string('nip');
          $table->string('nip_lama')->nullable();
          $table->string('no_ktp');
          $table->string('no_kk');
          $table->string('no_npwp')->nullable();
          $table->string('nama');
          $table->date('tanggal_lahir');
          $table->string('jenis_kelamin', 1);
          $table->string('email')->nullable();
          $table->text('alamat');
          $table->string('agama');
          $table->string('no_telp')->nullable();
          $table->string('status_pajak')->nullable();
          $table->string('kewarganegaraan')->nullable();
          $table->string('bpjs_kesehatan')->nullable();
          $table->string('bpjs_ketenagakerjaan')->nullable();
          $table->string('no_rekening')->nullable();
          $table->string('nama_darurat')->nullable();
          $table->string('alamat_darurat')->nullable();
          $table->string('hubungan_darurat')->nullable();
          $table->string('telepon_darurat')->nullable();
          $table->string('gaji_pokok')->nullable();
          $table->integer('workday')->unsigned()->nullable();
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
