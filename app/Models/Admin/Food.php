<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    //指定表
    protected $table = 'food';
    //指定主键
    protected $primaryKey = 'id';
    //过滤，只有以下字段才能被修改
    protected $fillable = ['id','food_name','food_category','food_age','price', 'sort_order','mark_up','created_at','updated_at'];
}
