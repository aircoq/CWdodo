<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use softDeletes;
    //指定表
    protected $table = 'role';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //过滤，只有以下字段才能被修改
    protected $fillable = ['id','role_name','note','role_auth_list','role_auth_adr'];
    //隐藏字段
    protected $hidden = ['password'];
    // 列表页显示的字段
//    protected $fields_show = [''];
}
