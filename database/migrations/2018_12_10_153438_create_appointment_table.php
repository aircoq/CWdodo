<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appointment_number')->comment('预约订单号');
            $table->dateTime('time_at')->comment('预约时间');
            $table->unsignedInteger('user_id')->comment('预约的用户');
            $table->string('user_name')->comment('预约时的用户名');
            $table->enum('sex',['1','2'])->default(2)->comment('预约用户性别:0女；1男；');
            $table->unsignedInteger('user_phone')->comment('预约时的电话号码');
            $table->enum('pet_id',['0','1'])->comment('宠物id');
//
            $table->string('province',60)->nullable()->comment('用户预约所在省');
            $table->string('city',60)->nullable()->comment('用户预约所在市');
            $table->string('district',60)->nullable()->comment('用户预约所在区县');
            $table->text('inn_address')->nullable()->comment('用户预约详细地址');
            $table->string('adcode',8)->nullable()->comment('用户预约所在高德区域编码');
            $table->string('lat',30)->comment('用户预约所在经度');
            $table->string('lng',30)->comment('用户预约所在纬度');
            $table->string('from_way',30)->comment('预约途径');
            $table->enum('is_pickup',['0','1'])->comment('是否接送');
            $table->enum('appointment_type',['0','1','2'])->comment('预约的服务类:0寄养；1洗澡；2美容；3SPA');
            $table->string('appointment_type',30)->comment('预约的服务类');
            $table->string('start_at',255)->nullable()->comment('寄养开始时间');
            $table->string('end_at',255)->nullable()->comment('寄养结束时间');
            $table->unsignedSmallInteger('food_id')->nullable()->comment('期间使用食品');
            $table->string('provider',30)->comment('接待者');
            $table->text('mark_up')->nullable()->comment('备注');
            $table->timestamps();//预约发起时间
            $table->softDeletes();//完成即软删除
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
