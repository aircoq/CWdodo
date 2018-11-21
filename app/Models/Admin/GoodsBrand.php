<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsBrand extends Model
{
    //使用软删除
    use SoftDeletes;
    //指定表
    protected $table = 'goods_attr';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //可编辑字段
    protected $fillable = ['id','attr_name','type_id','attr_type','attr_input_type','attr_values','sort_order','note','is_linked','created_at','updated_at', 'deleted_at'];
}
