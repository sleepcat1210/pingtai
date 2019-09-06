<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $table = "members"; //表名
    protected $primaryKey = "uid"; //主键名字
    protected $fillable = [
        'user_name',
        'user_password',
        'real_password',
        'user_status',
        'user_headimg',
        'user_tel', 
        'user_tel_bind',
        'user_qq',
        'qq_openid',
        'qq_info',
        'user_email',
        'sex',
        'wx_openid',
        'wx_sub_time',
        'wx_unionid',
        'wx_info',
        'members_level',
        'reg_time'    
    ]; 
}
