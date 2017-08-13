<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrBatchProcessedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_batch_processed', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_batch_payroll')->unsigned()->nullable();
          $table->integer('id_periode')->unsigned()->nullable();
          $table->date('tanggal_proses_payroll');
          $table->date('tanggal_cutoff_awal');
          $table->date('tanggal_cutoff_akhir');
          $table->integer('total_pegawai')->default(0)->unsigned();
          $table->integer('total_penerimaan_gaji')->default(0)->unsigned();
          $table->integer('total_potongan_gaji')->default(0)->unsigned();
          $table->integer('total_pengeluaran')->default(0)->unsigned();
          $table->timestamps('');

          $table->foreign('id_batch_payroll')->references('id')->on('pr_batch_payroll');
          $table->foreign('id_periode')->references('id')->on('pr_periode_gaji');
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
