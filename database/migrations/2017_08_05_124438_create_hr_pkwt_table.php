<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrPkwtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_pkwt', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned();
          $table->integer('id_cabang_client')->unsigned();
          $table->integer('id_kelompok_jabatan')->unsigned();
          $table->date('tanggal_masuk_gmt');
          $table->date('tanggal_masuk_client');
          $table->integer('status_pkwt')->unsigned();
          $table->date('tanggal_awal_pkwt');
          $table->date('tanggal_akhir_pkwt');
          $table->integer('status_karyawan_pkwt')->unsigned();
          $table->integer('flag_terminate')->unsigned();
          $table->timestamps();

          $table->foreign('id_pegawai')->references('id')->on('master_pegawai');
          $table->foreign('id_cabang_client')->references('id')->on('master_client_cabang');
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
