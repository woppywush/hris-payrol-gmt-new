<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrPendidikanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_pendidikan', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned();
          $table->string('jenjang_pendidikan')->nullable();
          $table->string('institusi_pendidikan')->nullable();
          $table->string('tahun_masuk_pendidikan')->nullable();
          $table->string('tahun_lulus_pendidikan')->nullable();
          $table->string('gelar_akademik')->nullable();
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
