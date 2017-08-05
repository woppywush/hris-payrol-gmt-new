<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrKeahlianKomputerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_keahlian_komputer', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned();
          $table->string('nama_program')->nullable();
          $table->string('nilai_komputer')->nullable();
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
