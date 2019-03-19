<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GoodsBrand extends Model
{
    //指定表
    protected $table = 'goods_brand';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //可编辑字段
    protected $fillable = ['id','brand_name','brand_logo','brand_desc','site_url','is_show','sort_order'];
}
