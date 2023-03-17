<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->integer('admin')->nullable();
            $table->integer('vendor')->nullable();
            $table->integer('customer')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->integer('is_active')->nullable();
            $table->string('password')->nullable();
            $table->string('recovery_expiry')->nullable();
            $table->string('change_password')->nullable();
            $table->string('recovery_code')->nullable();
            $table->integer('role_id')->nullable();
            $table->string('address')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
