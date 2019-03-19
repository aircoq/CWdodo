<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodTable extends Migration
{
    public function up()
    {
        #宠物食品表
        Schema::create('food', function (Blueprint $table) {
            $table->increments('id');
            $table->string('food_name',10)->comment('食物名称');
            $table->enum('food_category',['0','1','2'])->comment('食物分类:0其他；1狗粮；2猫粮');
            $table->enum('food_age',['0','1','2','3'])->comment('适用年龄:0离乳期；1幼年；2成年；3老年');
            $table->integer('price')->comment('单价(元/天)');
            $table->unsignedInteger('sort_order')->nullable()->comment('显示时的排序字段，越大越靠前');
            $table->text('mark_up')->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('food');
    }
}
