<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrPengecualianClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_pengecualian_client', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_pegawai')->unsigned()->nullable();
          $table->integer('id_cabang_client')->unsigned()->nullable();
          $table->integer('flag_status')->default(0)->nullable();
          $table->timestamps();

          $table->foreign('id_cabang_client')->references('id')->on('master_client_cabang');
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
