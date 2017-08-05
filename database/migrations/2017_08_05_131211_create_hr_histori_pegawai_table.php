<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrHistoriPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_histori_pegawai', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned();
          $table->text('keterangan')->nullable();
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
