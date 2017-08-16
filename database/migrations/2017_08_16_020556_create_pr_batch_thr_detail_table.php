<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrBatchThrDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_batch_thr_detail', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_batch_thr')->unsigned()->nullable();
          $table->integer('id_pegawai')->unsigned()->nullable();
          $table->integer('bulan_kerja');
          $table->biginteger('nilai_prorate');
          $table->biginteger('nilai_thr');
          $table->timestamps();

          $table->foreign('id_batch_thr')->references('id')->on('pr_batch_thr');
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
