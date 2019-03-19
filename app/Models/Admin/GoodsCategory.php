<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsCategory extends Model
{
    //使用软删除
    use SoftDeletes;
    //指定表
    protected $table = 'goods_category';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //可编辑字段
    protected $fillable = ['id','cate_name','cat_desc','p_id','show_in_nav','is_show','first_p_id','path','sort_order','created_at','updated_at', 'deleted_at'];
}
