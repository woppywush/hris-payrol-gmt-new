<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrBatchThrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_batch_thr', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_periode_gaji')->unsigned()->nullable();
          $table->date('tanggal_generate');
          $table->string('bulan_awal');
          $table->string('bulan_akhir');
          $table->integer('diff_bulan');
          $table->integer('flag_processed');
          $table->timestamps();

          $table->foreign('id_periode_gaji')->references('id')->on('pr_periode_gaji');
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
