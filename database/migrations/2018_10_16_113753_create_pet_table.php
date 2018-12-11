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
        # 宠物信息表
        Schema::create('pet',function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键ID');
            $table->unsignedInteger('user_id')->comment('主人id');
            $table->string('pet_avatar',255)->nullable()->comment('宠物头像');
            $table->enum('male',['0','1'])->comment('性别:0母;1公');
            $table->string('pet_name',50)->nullable()->comment('宠物昵称');
            $table->enum('pet_category',['0','1'])->comment('宠物类型：0狗；1猫');
            $table->string('varieties',50)->nullable()->comment('宠物品种');
            $table->unsignedTinyInteger('height')->nullable()->comment('宠物身高');
            $table->unsignedTinyInteger('weight')->nullable()->comment('体重');
            $table->string('color',7)->nullable()->comment('色系');
            $table->enum('status',['-1','0','1'])->default(2)->comment('状态:-1病态；0正常；1优秀');
            $table->unsignedTinyInteger('star')->default(8)->comment('爱星：满星10星');
            $table->date('birthday')->nullable()->comment('宠物出生日');
            $table->string('born_where')->nullable()->comment('宠物产地');
            $table->text('pet_desc')->nullable()->comment('宠物描述');
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
