<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # 商品属性
        Schema::create('goods_attr',function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键ID');
            $table->string('attr_name', 50)->comment('属性名称');
            $table->unsignedInteger('type_id')->comment('商品类型id');
            $table->enum('attr_type',['0','1'])->default(0)->comment('是否可以多选：0单选；1多选但唯一');
            $table->enum('attr_input_type',['0','1'])->default(0)->comment('属性的录入方式：0手工;1列表选择');
            $table->string('attr_values',255)->nullable()->comment('属性的可选值，当属性的录入方式为列表选择的时候对应的可选值，使用逗号进行分割');
            $table->unsignedTinyInteger('sort_order')->nullable()->comment('属性排序字段');
            $table->text('note')->nullable()->comment('属性描述');
            $table->enum('is_linked',['0','1'])->default(0)->comment('是否关联:0不关联；1关联,那么用户在购买该商品时，推荐相同属性给用户');
            $table->timestamps();
            $table->softDeletes();
        });

        # 商品类型
        Schema::create('goods_type',function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallincrements('id')->comment('主键ID');
            $table->string('type_name', 50)->unique()->comment('商品类型名');
            $table->text('mark_up')->nullable()->comment('商品类型说明');
            $table->timestamps();
            $table->softDeletes();
        });

        # 商品分类表
        Schema::create('goods_category',function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallincrements('id')->comment('主键ID');
            $table->string('cate_name', 50)->unique()->comment('商品分类名称');
            $table->unsignedSmallInteger('p_id')->comment('该分类的父id');
            $table->enum('show_in_nav',['0','1'])->default(1)->comment('是否显示在顶部导航栏：0否；1是');
            $table->enum('is_show',['0','1'])->default(1)->comment('是否显示在左侧菜单：0否；1是');
            $table->unsignedInteger('first_p_id')->comment('所属一级分类，一级分类为0');//减少递归内存消耗
            $table->unsignedInteger('path')->comment('层级关系');//减少递归内存消耗
            $table->unsignedSmallInteger('sort_order')->nullable()->comment('排序权重');
            $table->text('cat_desc')->nullable()->comment('分类描述');
            $table->timestamps();
            $table->softDeletes();
        });

        # 商品品牌表
        Schema::create('goods_brand',function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallincrements('id')->comment('主键ID');
            $table->string('brand_name', 50)->comment('品牌名称');
            $table->text('brand_logo')->nullable()->comment('品牌公司logo');
            $table->text('brand_desc')->nullable()->comment('品牌描述');
            $table->string('site_url')->nullable()->comment('品牌网站');
            $table->enum('is_show',['0','1'])->default(1)->comment('该品牌是否显示0否；1显示');
            $table->unsignedTinyInteger('sort_order')->nullable()->comment('排序字段');
        });

        # 商品表
        Schema::create('goods',function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键ID');
            $table->string('goods_sn')->comment('商品编码');
            $table->string('goods_name', 50)->comment('商品名称');
            $table->unsignedSmallInteger('cate_id')->comment('所属分类');
            $table->unsignedSmallInteger('type_id')->comment('商品类型id(属性框)');
            $table->unsignedSmallInteger('brand_id')->nullable()->comment('品牌id');
            $table->unsignedSmallInteger('inventory')->comment('商品库存数量');
            $table->unsignedSmallInteger('warn_num')->comment('报警数量');
            $table->decimal('goods_weight', 5, 2)->nullable()->comment('商品的重量-KG');
            $table->decimal('market_price', 8, 2)->comment('市场价');
            $table->decimal('shop_price', 8, 2)->comment('本店价');
            $table->decimal('promote_price', 8, 2)->nullable()->comment('促销价格');
            $table->date('promote_start_at')->nullable()->comment('促销开始时间');
            $table->date('promote_end_at')->nullable()->comment('促销结束时间');
            $table->string('goods_thumb', 200)->nullable()->comment('商品在前台显示的微缩图片，搜索的时候显示');
            $table->jsonb('goods_img')->nullable()->comment('商品轮播图');
            $table->enum('is_real',['0','1'])->default('1')->comment('是否是实物：0否比如服务、虚拟卡；1是');
            $table->enum('is_on_sale',['0','1'])->comment('是否开放售卖：0否；1是');
            $table->enum('is_alone_sale',['0','1'])->default('1')->comment('能否单独售卖：0否作为配件或者赠品销售；1是');
            $table->enum('is_best',['0','1'])->default('0')->comment('是否精品：0否；1是');
            $table->enum('is_new',['0','1'])->default('0')->comment('是否新品：0否；1是');
            $table->enum('is_hot',['0','1'])->default('0')->comment('是否热销：0否；1是');
            $table->enum('is_promote',['0','1'])->default('0')->comment('是否特价促销：0否；1是');
            $table->unsignedSmallInteger('integral')->nullable()->comment('所需积分');
            $table->unsignedInteger('sort_order')->nullable()->comment('搜索时的排序字段，越大越靠前');
            $table->text('goods_desc')->nullable()->comment('商品描述富文本');
            $table->string('seller_note',150)->nullable()->comment('商品的商家备注，仅商家可见');
            $table->unsignedSmallInteger('give_integral')->nullable()->comment('购买商品时赠送的积分');
            $table->string('extension_code', 200)->nullable()->comment('商品的扩展属性');
            $table->string('keywords', 20)->nullable()->comment('商品关键字');
            $table->timestamps();//商品创建时间
            $table->softDeletes();//一般来说商品信息是不能物理删除
            //关联关系
            $table->foreign('cate_id')->references('id')->on('goods_category') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('goods_type') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('goods_brand') ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
        Schema::dropIfExists('goods_attr');
        Schema::dropIfExists('goods_type');
        Schema::dropIfExists('goods_category');
        Schema::dropIfExists('goods_brand');
    }
}
