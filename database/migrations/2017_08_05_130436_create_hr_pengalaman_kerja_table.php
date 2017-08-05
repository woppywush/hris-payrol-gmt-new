<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrPengalamanKerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_pengalaman_kerja', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned();
          $table->string('nama_perusahaan')->nullable();
          $table->string('posisi_perusahaan')->nullable();
          $table->string('tahun_awal_kerja')->nullable();
          $table->string('tahun_akhir_kerja')->nullable();
          $table->timestamps();

          $table->foreign('id_pegawai')->references('id')->on('master_pegawai');
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
