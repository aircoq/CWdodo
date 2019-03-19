<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    //使用软删除
    use SoftDeletes;
    //使用通知功能
    use Notifiable;
    //指定表
    protected $table = 'user';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //是否开启时间戳,自动维护时间戳
//    protected $timestamps = false;
    //过滤，只有以下字段才能被修改
    protected $fillable = ['id','nickname','phone','email','password','sex', 'user_status','integral','frozen_integral','user_money','frozen_money','credit_line','cost_total','user_level', 'avatar','birthday','city','height','weight','has_medal','flag','address_id','qr_code','parent_id','zone_cate_id','fans_list','friends_list','last_ip','last_login','remember_token','desc','note','question_answer','created_at','updated_at', 'deleted_at'];
    //隐藏字段
    protected $hidden = ['password'];

    /**
     * 邮件频道的路由
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
