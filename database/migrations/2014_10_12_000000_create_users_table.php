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
            $table->id();
            $table->string('account')->comment('账户')->unique();
            $table->string('password')->comment('密码');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('phone')->nullable()->comment('手机号码')->unique();
            $table->string('email')->nullable()->unique();
            $table->text('introduction')->nullable()->comment('用户介绍');
            $table->tinyInteger('status')->default(0)->comment('用户状态 0-启用 1-禁用');
            $table->timestamp('email_verified_at')->nullable();
            $table->index(['id']);
            $table->rememberToken();
            $table->softDeletes();
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
