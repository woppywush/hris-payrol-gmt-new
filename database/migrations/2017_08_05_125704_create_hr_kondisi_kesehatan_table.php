<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrKondisiKesehatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_kondisi_kesehatan', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned();
          $table->integer('tinggi_badan')->unsigned()->nullable();
          $table->integer('berat_badan')->unsigned()->nullable();
          $table->string('warna_rambut')->nullable();
          $table->string('warna_mata')->nullable();
          $table->integer('berkacamata')->unsigned()->nullable();
          $table->integer('merokok')->unsigned()->nullable();
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
