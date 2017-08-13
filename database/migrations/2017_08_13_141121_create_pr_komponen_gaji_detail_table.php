<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrKomponenGajiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_komponen_gaji_detail', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_batch_payroll_detail')->unsigned()->nullable();
          $table->integer('id_komponen_gaji')->unsigned()->nullable();
          $table->integer('nilai')->unsigned()->nullable();
          $table->timestamps();

          $table->foreign('id_batch_payroll_detail')->references('id')->on('pr_batch_payroll_detail');
          $table->foreign('id_komponen_gaji')->references('id')->on('master_komponen_gaji');
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
