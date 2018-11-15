<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    //使用软删除
    use SoftDeletes;
    //指定表
    protected $table = 'admin';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //是否开启时间戳,自动维护时间戳
//    protected $timestamps = false;
    //过滤，只有以下字段才能被修改
    protected $fillable = ['id','username','phone','email','password','role_id','sex', 'admin_status', 'avatar','friends_list','last_ip','last_login','login_total','remember_token','agency_id','note','created_at','updated_at', 'deleted_at'];
    //隐藏字段
    protected $hidden = ['password','remember_token'];
    // 列表页显示的字段
//    protected $fields_show = [''];
    # 用户和角色的模型关联关系
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class,'role');
    }
    /****************************************
     * 封装一个方法方便使用 1. 需要的权限 2. 遍历当期那用户拥有的所有权限 3. 再通过角色判断是否有当前需要的权限
     ****************************************/
    public function hasAuth($authName)
    {
        foreach ($this->roles as $role) {
//            if ($role->$authName->where('name', $authName)->exists()) {
//                return true;;
//            }
        }
        return false;
    }




}