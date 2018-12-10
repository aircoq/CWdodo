<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class InnRoom extends Model
{
    public $timestamps = false;
    //指定表
    protected $table = 'inn_room';
    //指定主键
    protected $primaryKey = 'id';
    //可编辑字段
    protected $fillable = ['id','room_number','inn_id','is_enable','room_type','bunk','pet_id','start_at','end_at','sort_order'];
}
