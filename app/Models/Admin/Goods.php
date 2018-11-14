<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    //使用软删除
    use SoftDeletes;
    //指定表
    protected $table = 'goods';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //可编辑字段
    protected $fillable = ['id','cate_id','goods_type','goods_name','brand_id','inventory','goods_weight','market_price','shop_price','promote_price','promote_start_at','promote_end_at','warn_num','keywords','goods_thumb','goods_img','is_real','extension_code','is_on_sale','is_alone_sale','is_best','is_new','is_hot','is_promote','integral','sort_order','goods_desc','give_integral','created_at','updated_at', 'deleted_at'];
}
