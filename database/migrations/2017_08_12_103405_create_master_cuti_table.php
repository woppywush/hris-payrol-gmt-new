<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterCutiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_cuti', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned();
          $table->string('jenis_cuti', 50);
          $table->integer('jumlah_hari')->unsigned()->nullable();
          $table->date('tanggal_mulai')->nullable();
          $table->date('tanggal_akhir')->nullable();
          $table->text('deskripsi');
          $table->string('berkas', 150)->nullable();
          $table->integer('flag_status')->unsigned()->nullable();
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
