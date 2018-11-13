<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddressModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # 用户表
        Schema::create('user', function (Blueprint $table) {
            //用户账号信息
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键ID');
            $table->string('phone',15)->unique()->comment('手机');
            $table->string('email',60)->nullable()->comment('邮箱');
            $table->string('password',255)->comment('密码');
            $table->string('remember_token', 60)->nullable()->comment('记住登录');
            $table->enum('user_status',['-2','-1','0','1'])->default(1)->comment('-2已停止;-1拒绝;0未审核;1已审核');
            //用户积分信息
            $table->unsignedInteger('integral')->nullable()->comment('积分');
            $table->unsignedInteger('frozen_integral')->nullable()->comment('用户冻结积分');
            $table->decimal('user_money',10,2)->nullable()->comment( '用户现有资金');
            $table->decimal('frozen_money',10,2)->nullable()->comment( '用户冻结资金');
            $table->decimal('credit_line',10,2)->nullable()->comment( '最大消费');
            $table->decimal('cost_total')->nullable()->comment('累积消费');
            //用户个人信息
            $table->string('nickname',150)->nullable()->comment('昵称');
            $table->unsignedSmallInteger('user_level')->default(0)->comment('账户等级');
            $table->string('avatar',255)->nullable()->comment('头像');
            $table->enum('sex',['0','1','2'])->default(2)->comment('性别:0女；1男；2保密');
            $table->dateTime('birthday')->nullable()->comment('生日');
            $table->string('city',40)->nullable()->default('深圳')->comment('所在城市');
            $table->unsignedSmallInteger('height')->nullable()->comment('身高');
            $table->unsignedSmallInteger('weight')->nullable()->comment('体重');
            $table->string('has_medal',255)->nullable()->comment('获得奖章');
            $table->text('flag')->nullable()->comment('用户标识');
            $table->mediumInteger('address_id')->nullable()->comment('默认的收货地址id');
            $table->string('qr_code',255)->nullable()->comment('二维码');
            //社交信息
            $table->mediumInteger('parent_id')->nullable()->comment('介绍人id');
            $table->jsonb('zone_cate_id')->nullable()->comment('关注的兴趣群，json格式');
            $table->jsonb('friends_list')->nullable()->comment('好友id,json格式');
            $table->jsonb('fans_list')->nullable()->comment('粉丝id,json格式');
            $table->string('desc',60)->nullable()->comment('个性签名');
            $table->string('note',100)->nullable()->comment('管理员对用户的备注');
            //密保信息
            $table->jsonb('question_answer')->nullable()->comment( '密保问题');
            $table->string('last_ip',50)->default(0)->comment('最后登陆IP');
            $table->unsignedInteger('last_login')->nullable()->comment('最后登陆时间');
            $table->timestamps();//注册时间
            $table->softDeletes();
        });

        # 用户地址信息
        Schema::create('user_address', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->string('consignee',100)->comment('收货人姓名');
            $table->string('Consignee_tel',15)->nullable()->comment('收货人电话');
            $table->string('Consignee_phone',15)->comment('收货人手机');
            $table->string('adr_label',150)->nullable()->comment('地址标签:家；公司；学校或自定义');
            $table->unsignedSmallInteger('country')->comment('国家');
            $table->unsignedSmallInteger('province')->comment('省份');
            $table->unsignedSmallInteger('city')->comment('城市');
            $table->unsignedSmallInteger('district')->comment('地区');
            $table->unsignedSmallInteger('street')->comment('街道');
            $table->string('address',255)->comment('收货人详细地址');
            $table->string('zip_code',60)->comment('收货人邮编:系统根据API自动生成');
            $table->timestamps();
        });
        # 用户积分和现金自操作记录表（对应的还有管理员操作记录表）
        Schema::create('user_account_log', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->mediumIncrements('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->enum('change_type',['0','1','2','99'])->comment('操作类型，0为充值，1为提现，2为管理员调节，99为其他类型');
            $table->unsignedInteger('integral')->nullable()->comment('使用前积分');
            $table->unsignedInteger('change_integral')->nullable()->comment('改变的积分数');
            $table->decimal('user_money',10,2)->nullable()->comment( '使用前余额');
            $table->decimal('change_money',10,2)->nullable()->comment( '改变的额度');
            $table->timestamps();//该笔操作时间
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
        Schema::dropIfExists('user');
        Schema::dropIfExists('user_address');
        Schema::dropIfExists('user_account_log');
    }
}
