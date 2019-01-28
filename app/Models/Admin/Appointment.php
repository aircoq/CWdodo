<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\AppointmentCreated;

class Appointment extends Model
{
    //使用软删除
    use SoftDeletes;
    //指定表
    protected $table = 'appointment';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //过滤，只有以下字段才能被修改
    protected $fillable = ['id','appointment_number','appointment_type','user_id','user_name','sex', 'user_phone', 'pet_id','is_pickup','province','city','district','address','lat','lng','from_way','start_at','end_at','food_id','provider','appointment_status','mark_up','created_at','updated_at', 'deleted_at'];
    //模型事件
//    protected $events = [
//        'created' => AppointmentCreated::class  , //key就是事件的名字，值就是触发的事件。这个事件可以是一个完整的类
//    ];
}
