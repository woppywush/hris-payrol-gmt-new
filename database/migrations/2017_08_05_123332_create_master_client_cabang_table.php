<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterClientCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_client_cabang', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_client')->unsigned();
          $table->string('kode_cabang');
          $table->string('nama_cabang');
          $table->string('alamat_cabang');
          $table->timestamps();

          $table->foreign('id_client')->references('id')->on('master_client');
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
