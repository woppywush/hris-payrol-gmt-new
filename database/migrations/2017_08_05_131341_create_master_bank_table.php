<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_bank', function(Blueprint $table){
          $table->increments('id');
          $table->string('nama_bank');
          $table->integer('flag_status')->unsigned();
          $table->timestamps();
        });

        Schema::table('master_pegawai', function(Blueprint $table){
          $table->foreign('id_bank')->references('id')->on('master_bank');
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
