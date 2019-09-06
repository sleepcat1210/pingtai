<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = "roles"; //表名
    protected $primaryKey = "role_id"; //主键名字
    protected $fillable = ['role_name','act_list','role_desc']; 
}
