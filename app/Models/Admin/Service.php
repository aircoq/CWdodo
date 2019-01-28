<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    //指定表
    protected $table = 'goods';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //可编辑字段
    protected $fillable = ['id','service_name','pet_type','service_thumb','created_at','updated_at', 'deleted_at'];
}
