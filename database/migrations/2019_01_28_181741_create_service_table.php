<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键ID');
            $table->string('service_name', 50)->comment('商品名称');
            $table->enum('pet_category',['0','1','2'])->comment('适用宠物类型：0其他；1狗；2猫');
            $table->string('service_thumb', 200)->nullable()->comment('商品在前台显示的微缩图片，搜索的时候显示');
            $table->enum('is_on_sale',['0','1'])->comment('是否开放售卖：0否；1是');
            $table->decimal('market_price', 8, 2)->comment('市场价');
            $table->decimal('shop_price', 8, 2)->comment('本店价');
            $table->unsignedInteger('sort_order')->nullable()->comment('搜索时的排序字段，越大越靠前');
            $table->timestamps();//商品创建时间
            $table->softDeletes();//一般来说商品信息是不能物理删除
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service');
    }
}
