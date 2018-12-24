<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function getStartAtAttribute()
    {
        return date('Y-m-d H:i', $this->attributes['start_at']);
    }
    public function getEndAtAttribute()
    {
        return date('Y-m-d H:i', $this->attributes['start_at']);
    }

}
