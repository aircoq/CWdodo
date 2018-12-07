<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInnModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # 单店表
        Schema::create('inn',function(Blueprint $table){
            // 声明表结构
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键ID');
            $table->string('inn_name',150)->nullable()->comment('门店名称');
            $table->string('inn_sn',25)->unique()->comment('门店编码');
            $table->unsignedTinyInteger('cate_id')->default(1)->comment('门店类型，暂时没开启此功能');
            $table->enum('is_self',['0','1'])->default(1)->comment('是否直营：0不是,1是');
            $table->enum('inn_status',['-2','-1','0','1'])->default(0)->comment('-2拒绝;-1已停止;0未审核;1已审核');
            $table->unsignedTinyInteger('is_running')->default(1)->comment('0休息中,1营业中(单店权限)');
            $table->string('inn_tel',15)->comment('门店电话');
            $table->string('lat',30)->comment('所在经度');
            $table->string('lng',30)->comment('所在纬度');
            $table->string('province',60)->nullable()->comment('门店所在省');
            $table->string('city',60)->nullable()->comment('门店所在市');
            $table->string('district',60)->nullable()->comment('门店所在区县');
            $table->string('adcode',8)->nullable()->comment('门店所在高德区域编码');
            $table->text('inn_address')->nullable()->comment('门店详细地址');
            $table->string('inn_logo',255)->nullable()->comment('门店头像');
            $table->string('inn_img',255)->nullable()->comment('门店图片');
            $table->string('start_time',10)->comment('营业开始时间');
            $table->string('end_time',10)->comment('营业结束时间');
            $table->string('inn_star',1)->default(5)->comment('门店星级');//暂用（店铺评论表‘inn_evaluation_star’暂未开发）
            $table->text('note',255)->nullable()->comment('门店备注');
            $table->unsignedInteger('admin_id')->nullable()->comment('门店所有人admin id,空为直营店');
            $table->unsignedTinyInteger('bank_id')->nullable()->comment('银行id');
            $table->string('bank_account_name',150)->nullable()->comment('银行卡所有人');
            $table->string('bank_account',60)->nullable()->comment('银行卡账号');
            $table->timestamp('contract_start_at')->nullable()->comment('签约门店合同开始时间：暂未开放');
            $table->timestamp('contract_end_at')->nullable()->comment('签约门店合同结束时间：暂未开放');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('admin_id')->references('id')->on('admin') ->onUpdate('cascade')->onDelete('cascade');
        });

        # 宠物房间表
        Schema::create('inn_room',function(Blueprint $table){
            $table->smallIncrements('id');
            $table->string('room_number')->comment('房间编号');
            $table->unsignedinteger('inn_id')->comment('所属商家');
            $table->enum('room_status',['0','1'])->default(1)->comment('是否可用：0不可用；1可用');
            $table->unsignedTinyInteger('room_type')->comment('房间类型:0普通；1中型；3大型；4豪华');
            $table->enum('bunk',['0','1','2'])->default(1)->comment('上下铺：0无；1下层；2上层');
            $table->unsignedInteger('pet_id')->nullable()->comment('所使用的宠物pet_id');
            $table->string('start_at',255)->nullable()->comment('寄养开始时间');
            $table->string('end_at',255)->nullable()->comment('寄养结束时间');
            $table->unsignedinteger('sort')->comment('排序');
            //关联关系
            $table->foreign('inn_id')->references('id')->on('inn') ->onUpdate('cascade')->onDelete('cascade');
        });

        # 店铺评论表（暂未开发）
        Schema::create('inn_evaluation_star',function(Blueprint $table){
            // 声明表结构
            $table->engine = 'InnoDB';
            $table->increments('id')->comment( '主键ID' );
            $table->unsignedInteger('user_id')->nullable()->comment( '当前评论人id' );
            $table->unsignedInteger('inn_id')->nullable()->comment( '当前所属店铺id' );
            $table->enum('star',['1','2','3','4','5'])->default(5)->comment('店铺评分');
            $table->unsignedInteger('parent_id')->nullable()->comment( '被评论evaluation_id' );
            $table->unsignedInteger('p_mid')->nullable()->comment( '被评论人user_id' );
            $table->text('content')->nullable()->comment('评论内容');
            $table->unsignedInteger('first_branch_id')->comment( '属于哪个一级评论下的，一级评论的first_branch是他本身' );
            $table->timestamps();//评论时间
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inn_room');
        Schema::dropIfExists('inn');
        Schema::dropIfExists('inn_evaluation_star');
    }
}
