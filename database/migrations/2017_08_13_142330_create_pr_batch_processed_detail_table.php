<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrBatchProcessedDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_batch_processed_detail', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned()->nullable();
          $table->integer('id_batch_processed')->unsigned()->nullable();
          $table->string('nip');
          $table->string('nama');
          $table->string('jabatan');
          $table->integer('hari_normal');
          $table->integer('abstain');
          $table->integer('sick_leave');
          $table->integer('permissed_leave');
          $table->integer('hari_kerja');
          $table->integer('penerimaan_tetap');
          $table->integer('penerimaan_variable');
          $table->integer('potongan_tetap');
          $table->integer('potongan_variable');
          $table->integer('total');
          $table->timestamps();

          $table->foreign('id_pegawai')->references('id')->on('master_pegawai');
          $table->foreign('id_batch_processed')->references('id')->on('pr_batch_processed');
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
