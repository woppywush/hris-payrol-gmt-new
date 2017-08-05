<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterJabatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_jabatan', function(Blueprint $table){
          $table->increments('id');
          $table->string('kode_jabatan');
          $table->string('nama_jabatan');
          $table->integer('status')->unsigned();
          $table->timestamps();
        });

        Schema::table('master_pegawai', function(Blueprint $table){
          $table->foreign('id_jabatan')->references('id')->on('master_jabatan');
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
