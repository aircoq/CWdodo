<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsType extends Model
{
    //使用软删除
    use SoftDeletes;
    //指定表
    protected $table = 'goods_type';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //可编辑字段
    protected $fillable = ['id','type_name','mark_up','created_at','updated_at', 'deleted_at'];
}
