<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentTable extends Migration
{
    public function up()
    {
        # 预约表
        Schema::create('appointment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appointment_number')->comment('预约订单号');
            $table->enum('appointment_type',['0','1','2'])->comment('预约的服务类型:0寄养；1洗澡；2美容；3SPA');
            $table->unsignedInteger('user_id')->comment('预约的用户id');
            $table->string('user_name',15)->comment('预约时的用户名');
            $table->enum('sex',['1','2'])->comment('预约用户性别:0女；1男；');
            $table->char('user_phone',11)->comment('预约时的电话号码');
            $table->unsignedInteger('pet_id')->comment('宠物id');
            $table->enum('is_pickup',['0','1'])->comment('是否接送');
            $table->string('province',60)->nullable()->comment('用户预约所在省');
            $table->string('city',60)->nullable()->comment('用户预约所在市');
            $table->string('district',60)->nullable()->comment('用户预约所在区县');
            $table->string('address',60)->nullable()->comment('用户预约详细地址');
            $table->string('lat',30)->nullable()->comment('用户预约所在经度');
            $table->string('lng',30)->nullable()->comment('用户预约所在纬度');
            $table->string('from_way',30)->comment('预约途径');
            $table->string('start_at',10)->nullable()->comment('预约开始时间（时间戳）');
            $table->string('end_at',10)->nullable()->comment('预约服务结束时间（时间戳）');
            $table->unsignedInteger('food_id')->nullable()->comment('期间使用食品');
            $table->string('provider',30)->nullable()->comment('接待者');
            $table->enum('appointment_status',['0','1'])->comment('接管状态：0未完成；1完成');
            $table->text('mark_up')->nullable()->comment('备注');
            $table->timestamps();//预约发起时间
            $table->softDeletes();//完成即软删除
            $table->foreign('user_id')->references('id')->on('user') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pet_id')->references('id')->on('pet') ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment');
    }
}
