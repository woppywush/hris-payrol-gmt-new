<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrKomponenGajiTetapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_komponen_gaji_tetap', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_komponen_gaji')->unsigned()->nullable();
          $table->integer('id_cabang_client')->unsigned()->nullable();
          $table->string('keterangan')->nullable();
          $table->double('komgaj_tetap_dibayarkan');
          $table->integer('flag_status')->unsigned()->nullable();
          $table->timestamps();

          $table->foreign('id_komponen_gaji')->references('id')->on('master_komponen_gaji');
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
