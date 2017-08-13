<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrPeriodeGajiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_periode_gaji_detail', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_periode_gaji')->unsigned()->nullable();
          $table->integer('id_pegawai')->unsigned()->nullable();
          $table->timestamps();

          $table->foreign('id_periode_gaji')->references('id')->on('pr_periode_gaji');
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
