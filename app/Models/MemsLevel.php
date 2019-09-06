<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemsLevel extends Model
{
    protected $table = "members_level"; //表名
    protected $primaryKey = "level_id"; //主键名字
    protected $fillable = ['level_name','amount','discount','describe']; 
}
