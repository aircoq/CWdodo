<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    //指定表
    protected $table = 'service';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //可编辑字段
    protected $fillable = ['id','service_name','pet_category','service_thumb','is_on_sale','market_price','shop_price','service_explain','tips','appointment_info','sort_order','created_at','updated_at', 'deleted_at'];
    //定义图片查询事件
    public function getServiceThumbAttribute()
    {
        if (!empty($this->attributes['service_thumb'])) {
            return $_SERVER["HTTP_HOST"].'/'.$this->attributes['service_thumb'];
        }
    }
}
