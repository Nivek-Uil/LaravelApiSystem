<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operate_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('用户ID');
            $table->string('account')->comment('操作账号');
            $table->string('uri')->comment('请求地址');
            $table->string('host')->comment('host');
            $table->string('route_name')->comment('路由名称');
            $table->string('method')->comment('请求方式：GET、POST、PUT、DELETE、HEAD');
            $table->ipAddress('ip')->comment('IP地址');
            $table->text('parameter')->nullable()->comment('参数');
            $table->string('user_agent')->comment('UserAgent 访问工具');
            $table->text('remark')->nullable()->comment('备注');
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
        Schema::dropIfExists('operate_logs');
    }
}
