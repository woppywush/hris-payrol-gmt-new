<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrainingToMasterPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_pegawai', function (Blueprint $table) {
            //
            $table->integer('jam_training')->default(0)->after('status')->nullable();
            $table->timestamp('tanggal_training')->after('jam_training')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('master_pegawai', function (Blueprint $table) {
        //     //
        // });
    }
}
