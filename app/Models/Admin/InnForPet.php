<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class InnForPet extends Model
{
    //使用软删除
    use SoftDeletes;
    //指定表
    protected $table = 'inn';
    //指定主键
    protected $primaryKey = 'id';
    //应更改为日期的属性
    protected $dates = ['deleted_at'];
    //可编辑字段
    protected $fillable = ['id','inn_name','inn_sn','cate_id','is_self','inn_status','is_running','inn_tel','lat','lng','province','city','district','adcode','inn_address','inn_avatar','inn_img','start_time','end_time','note','admin_id','bank_id','bank_account_name','bank_account','create_at','updated_at', 'deleted_at'];
}
