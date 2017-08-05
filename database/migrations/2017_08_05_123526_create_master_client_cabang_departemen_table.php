<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterClientCabangDepartemenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_client_cabang_departemen', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_cabang')->unsigned();
          $table->string('kode_departemen');
          $table->string('nama_departemen');
          $table->timestamps();

          $table->foreign('id_cabang')->references('id')->on('master_client_cabang');
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
