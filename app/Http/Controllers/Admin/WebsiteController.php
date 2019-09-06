<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Website;
class WebsiteController extends Controller
{
    //首页
    public function index(){     
        $web = new Website();
        $website= $web::first();   
        return view('admin.website.index',compact('website'));
    }
    //上传图片
    public function upImg(Request $request){
        $file = $request->file('file');
        if($file->isValid()){            
            $rst = $file->store('img','public');          
            echo json_encode(['success'=>true,'data'=>'storage/'. $rst]);
        }else{
            echo json_encode(['success'=>false]);
        }
        exit;
    }
    public function add(Request $request,Website $website){
        if ($request->isMethod("post")) {
            $data = $request->all();
            $form_data = [
                'title' => $data['title'],
                'logo' => $data['logo'],
                'web_desc' => $data['web_desc'],
                'key_words' => $data['key_words'],
                'web_icp' => $data['web_icp'],
                'wx_appid' => $data['wx_appid'],
                'wx_token' => $data['wx_token'],
                'appsecret' => $data['appsecret'],
            ];
            $result = $website->update($form_data);
            if ($result) {
                return ['success' => true];
            } else {
                return ['success' => false, 'errorinfo' => '编辑失败!'];
            }
        }  
       }
    
}
