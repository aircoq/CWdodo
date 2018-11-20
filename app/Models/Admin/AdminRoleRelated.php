<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminRoleRelated extends Model
{
    use softDeletes;
    //指定表
    protected $table = 'admin_role_related';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //过滤，只有以下字段才能被修改
    protected $fillable = ['id','admin_role_id','admin_id','created_at','updated_at', 'deleted_at'];

}
