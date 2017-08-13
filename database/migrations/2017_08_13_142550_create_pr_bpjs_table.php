<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrBpjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pr_bpjs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_bpjs')->unsigned()->nullable();
            $table->integer('id_cabang_client')->unsigned()->nullable();
            $table->double('bpjs_dibayarkan');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_bpjs')->references('id')->on('master_komponen_gaji');
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
