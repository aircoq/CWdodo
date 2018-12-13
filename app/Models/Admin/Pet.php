<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pet';
    //指定主键
    protected $primaryKey = 'id';
    //过滤，只有以下字段才能被修改
    protected $fillable = ['id','user_id','pet_thump','male','pet_name','pet_category','varieties','height','weight','color','status','star','birthday','born_where','room_id','pet_desc','created_at','updated_at'];
}