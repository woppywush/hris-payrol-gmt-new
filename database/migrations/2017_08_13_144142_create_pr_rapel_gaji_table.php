<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrRapelGajiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_rapel_gaji', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_histori')->unsigned()->nullable();
          $table->date('tanggal_proses');
          $table->integer('flag_processed');
          $table->timestamps();

          $table->foreign('id_histori')->references('id')->on('pr_histori_gaji_pokok_per_client');
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
