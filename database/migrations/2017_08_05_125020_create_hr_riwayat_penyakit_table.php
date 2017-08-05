<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrRiwayatPenyakitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_riwayat_penyakit', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned();
          $table->string('nama_penyakit')->nullable();
          $table->text('keterangan_penyakit')->nullable();
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
