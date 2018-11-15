<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auth extends Model
{
    use softDeletes;
    //指定表
    protected $table = 'auth';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //是否开启时间戳,自动维护时间戳
//    protected $timestamps = false;
    //过滤，只有以下字段才能被修改
    protected $fillable = ['id','auth_name','auth_controller','auth_action','auth_pid','is_menu','is_enable','path','sort_order','auth_desc','created_at','updated_at', 'deleted_at'];

}
