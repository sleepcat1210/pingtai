<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WxMenu extends Model
{
    protected $table = "weixin_menu"; //表名
    protected $primaryKey = "menu_id"; //主键名字    
    protected $fillable = ['menu_name','pid','menu_event_type','menu_content','sort',];
}
