<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterKomponenGajiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_komponen_gaji', function(Blueprint $table){
          $table->increments('id');
          $table->string('nama_komponen')->nullable();
          //D = Pendapatan, P = Potongan
          $table->string('tipe_komponen')->nullable();
          //Bulanan - Harian - Jam - Shift
          $table->string('periode_perhitungan')->nullable();
          $table->integer('flag_status')->unsigned();
          $table->integer('tipe_komponen_gaji')->unsigned();
          $table->timestamps();
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
