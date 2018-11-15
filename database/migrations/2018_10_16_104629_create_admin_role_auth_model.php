<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRoleAuthModel extends Migration
{
    public function up()
    {
        # 权限表
        Schema::create('auth',function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键ID') ;
            $table->string('auth_name',50) ->comment('权限名称:如果controller、action都为空则为一级菜单');
            $table->string('auth_controller',50) ->nullable() ->comment('权限所属控制器，如果是顶级，则用字符串null表示');
            $table->string('auth_action',50) ->nullable() ->comment('权限所属方法，如果是顶级，则用字符串null表示');
            $table->integer('auth_pid') ->default(0) ->comment('父级ID，如果是顶级权限，则为0；否则其他的为自己父级的主键ID');
            $table->string('auth_route_name')->comment('如：');
            $table->enum('is_menu',['0','1'])->default(0)->comment('是否作为左边的菜单显示:0否，1是(可能是button)');
            $table->enum('is_enable',['0','1'])->default(1)->comment('是否可用:0否，1是');
            $table->unsignedInteger('path')->comment('层级关系');//减少递归内存消耗
            $table->unsignedInteger('sort_order')->nullable()->comment('显示时的排序字段，越大越靠前');
            $table->string('auth_desc')->nullable()->comment('权限描述');
            $table->timestamps();
            $table->softDeletes();
        });

        # 角色表
        Schema::create('role',function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->smallincrements('id')->comment('主键ID');
            $table->string('role_name',50)->unique()->comment('角色名称');
            $table->text('role_auth_id_list')->nullable()->comment('权限列表字符串集：*超级管理员不受权限管理，1初始化角色不受权限管理');
            $table->text('note')->nullable()->comment('角色描述');
            $table->timestamps();
            $table->softDeletes();
        });

        # 管理员表
        Schema::create('admin',function (Blueprint $table){
            //基本信息
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键ID');
            $table->string('username',150)->coment('用户名');
            $table->string('phone','15')->unique()->comment('手机');
            $table->string('email',150)->comment('邮箱');
            $table->string('password','255')->comment('登陆密码');
            //权限管理
            $table->string('role_id',6)->commemt('角色ID:*为超级管理员;1初始化角色;2......');
            $table->enum('admin_status',['-2','-1','0','1'])->default(0)->comment('-2拒绝;-1已停止;0未审核;1已审核');
            //社交
            $table->jsonb('friends_list')->nullable()->comment( '关注的好友,json格式' );
            //账号相关信息
            $table->rememberToken()->comment('记住登录');
            $table->enum('sex',['0','1','2'])->default('2')->comment('性别:0为女性;1为男性;2保密');
            $table->unsignedSmallInteger('agency_id')->default(0)->commemt('该管理员负责的办事处理的id,如果没有为0');
            $table->string('avatar',255)->nullable()->comment('头像');//null=sys_img/user_avatar.png
            $table->string('last_ip',50)->default(0)->comment('最后登陆IP');
            $table->unsignedInteger('last_login')->nullable()->comment('最后登陆时间');
            $table->unsignedSmallInteger('login_total')->default(0)->comment('登陆总次数');
            $table->text('note')->nullable()->comment('备注');
            $table->timestamps();//创建时间created_at，更新时间updated_at
            $table->softDeletes();//禁用时间：deleted_at
            //关联关系
//            $table->foreign('role_id')->references('id')->on('role') ->onUpdate('cascade')->onDelete('cascade');//超级管理员为*
        });

        # 管理员积分和现金操作记录表
        Schema::create('admin_account_log', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->mediumIncrements('id');
            $table->unsignedInteger('admin_id')->comment('用户id');
            $table->unsignedInteger('admin_name')->comment('当时操作的管理员名字');
            $table->enum('process_type',['0','1'])->comment('操作类型：1退款；0预付费其实就是充值卡');
            $table->enum('payment',['0','1','2','3'])->comment('支付方式：0现金；1银行卡；2支付宝；3微信');
            $table->decimal('amount',10,2)->nullable()->comment( '资金的数目，正数为增加，负数为减少');
            $table->enum('is_paid',['0','1'])->comment('是否已经付款：0未付；1已付');
            $table->string('admin_note')->nullable()->comment('管理员备注');
            $table->string('user_note')->nullable()->comment('用户备注');
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
        Schema::dropIfExists('admin');
        Schema::dropIfExists('role');
        Schema::dropIfExists('auth');
        Schema::dropIfExists('admin_account_log');

    }
}
