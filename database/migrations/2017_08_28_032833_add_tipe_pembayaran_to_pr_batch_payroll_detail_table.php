<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipePembayaranToPrBatchPayrollDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pr_batch_payroll_detail', function (Blueprint $table) {
            //0 = cash, 1 = rekening
          $table->integer('tipe_pembayaran')->default(1)->after('permissed_leave')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('pr_batch_payroll_detail', function (Blueprint $table) {
        //     //
        // });
    }
}
