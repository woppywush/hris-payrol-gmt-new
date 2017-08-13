<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrBatchPayrollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_batch_payroll', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_periode_gaji')->unsigned()->nullable();
          $table->date('tanggal_proses');
          $table->date('tanggal_proses_akhir');
          $table->integer('flag_processed')->default(0)->unsigned();
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
