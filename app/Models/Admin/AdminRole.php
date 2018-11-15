<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminRole extends Model
{
    use softDeletes;
    //指定表
    protected $table = 'admin_role';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //过滤，只有以下字段才能被修改
    protected $fillable = ['id','role_name','role_auth_id_list','note','created_at','updated_at', 'deleted_at'];
    //隐藏字段
    protected $hidden = ['password'];
    // 列表页显示的字段
//    protected $fields_show = [''];

    // 用户和角色的模型关联关系 多对多
    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }

    // 角色和权限的模型关联关系 多对多
    public function roleAuth()
    {
        return $this->belongsToMany(RoleAuth::class);
    }
}
