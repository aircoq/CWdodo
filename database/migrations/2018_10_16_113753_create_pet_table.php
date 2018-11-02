<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # 宠物类别表
        # 宠物信息表
        Schema::create('pet',function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键ID');
            $table->unsignedInteger('user_id')->comment('主人id');
            $table->string('pet_avatar',255)->default('sys_img/pet_avatar.png')->nullable()->comment('宠物头像');
            $table->enum('sex',['0','1'])->comment('性别:0母;1公');
            $table->string('pet_name',50)->nullable()->comment('宠物昵称');
            $table->string('typename',50)->nullable()->comment('宠物品种');
            $table->unsignedTinyInteger('height')->nullable()->comment('宠物身高');
            $table->unsignedTinyInteger('weight')->nullable()->comment('体重');
            $table->string('color',7)->nullable()->comment('色系');
            $table->unsignedTinyInteger('love')->default(8)->comment('爱星：满星10星');
            $table->enum('status',['1','2','3'])->default(2)->comment('状态:1优秀,2正常,3病态');
            $table->dateTime('birthday')->nullable()->comment('宠物出生日');
            $table->string('born_where')->nullable()->comment('宠物产地');
            $table->smallInteger('pet_room_id')->nullable()->comment('房间id');
            $table->text('note')->nullable()->comment('宠物描述');
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
        Schema::dropIfExists('pet');
    }
}
