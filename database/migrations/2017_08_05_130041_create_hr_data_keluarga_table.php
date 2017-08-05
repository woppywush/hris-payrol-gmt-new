<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrDataKeluargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_data_keluarga', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned();
          $table->string('nama_keluarga')->nullable();
          $table->string('hubungan_keluarga')->nullable();
          $table->string('tanggal_lahir_keluarga')->nullable();
          $table->string('alamat_keluarga')->nullable();
          $table->string('pekerjaan_keluarga')->nullable();
          $table->string('jenis_kelamin_keluarga', 1)->nullable();
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
