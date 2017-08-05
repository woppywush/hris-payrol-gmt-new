<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('url_foto');
            $table->integer('login_count')->nullable()->default(1);
            // 0 = superadmin; 1 = HRD; 2 = Payroll; 3 = DirOps
            $table->integer('level')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
