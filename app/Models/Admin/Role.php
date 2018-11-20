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
    protected $fillable = ['id','role_name','note','created_at','updated_at', 'deleted_at'];
    //隐藏字段
    protected $hidden = ['password'];

    public function getAuth()
    {
        return $this->belongsToMany(Auth::class, 'role_auth_related', 'admin_role_id', 'role_auth_id')->withPivot(['admin_role_id', 'role_auth_id']);
    }

}
