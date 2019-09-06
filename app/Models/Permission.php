<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permission"; //表名
    protected $primaryKey = "act_id"; //主键名字
    protected $fillable = ['act_name','act_c','act_m','act_r','pid','act_icon']; 
    //关联权限
    public function permiss(){
        return $this->belongsTo(\App\Models\Permission::class,'pid','act_id');
    }
}
