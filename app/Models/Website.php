<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $table = "website"; //表名
    protected $primaryKey = "website_id"; //主键名字    
    protected $fillable = ['title','logo','web_desc','key_words','web_icp','wx_appid','wx_token','appsecret'];
}
