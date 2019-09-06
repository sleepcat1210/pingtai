<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Users extends Authenticatable
{
    protected $table = "users"; //表名
    protected $primaryKey = "id"; //主键名字
    protected $fillable = ['name','sex','phone','role_id', 'email', 'password','status']; //数据添加、修改时允许维护的字段

    public function roles(){
        return $this->hasOne(\App\Models\Roles::class,'role_id','role_id');
    }
}
