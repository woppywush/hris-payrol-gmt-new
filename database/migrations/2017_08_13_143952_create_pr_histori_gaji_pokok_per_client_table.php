<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrHistoriGajiPokokPerClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_histori_gaji_pokok_per_client', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_client')->unsigned()->nullable();
          $table->integer('id_cabang_client')->unsigned()->nullable();
          $table->date('tanggal_penyesuaian');
          $table->integer('nilai')->unsigned();
          $table->integer('flag_rapel_gaji')->default(0)->unsigned();
          $table->timestamps();

          $table->foreign('id_client')->references('id')->on('master_client');
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
