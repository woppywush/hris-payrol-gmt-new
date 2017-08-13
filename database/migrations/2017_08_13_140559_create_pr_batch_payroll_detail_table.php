<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrBatchPayrollDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_batch_payroll_detail', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_batch_payroll')->unsigned()->nullable();
          $table->integer('id_pegawai')->unsigned()->nullable();
          $table->integer('workday')->unsigned()->nullable();
          $table->integer('abstain')->default(0)->unsigned()->nullable();
          $table->integer('sick_leave')->default(0)->unsigned()->nullable();
          $table->integer('permissed_leave')->default(0)->unsigned()->nullable();
          $table->timestamps();

          $table->foreign('id_batch_payroll')->references('id')->on('pr_batch_payroll');
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
