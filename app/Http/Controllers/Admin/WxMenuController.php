<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WxMenu;
class WxMenuController extends Controller
{
    //微信菜单
    public function index(Wxmenu $wxmenu){
        $menu =$wxmenu->get();       
        $menu_list =getTrees($menu,0,'menu_id','pid',0);       
        return view('admin.wxmenu.index',compact('menu_list'));
    }
    //添加菜单
    public function add(Request $request,WxMenu $wxmenu){
        if($request->isMethod('post')){
            $data=$request->all();
            $result=$wxmenu->create([
                'menu_name'=>$data['menu_name'],
                'pid'=>$data['pid'],
                'menu_event_type'=>$data['menu_event_type'],
                'menu_content'=>$data['menu_content'],
                'sort'=>$data['sort'],               
            ]);
            if($result){
                return ['success'=>true];
            }else{     
                return ['success'=>false];
            }
        }else{
            $data=$wxmenu->get();           
            $menu_list =getTrees($data,0,'menu_id','pid'); 
            return view('admin.wxmenu.add',compact('menu_list'));
        }
    }
    //编辑菜单
    public function edit(Request $request,WxMenu $wxmenu){
        if($request->isMethod('post')){
            $data=$request->all();
            $result=$wxmenu->update([
                'menu_name'=>$data['menu_name'],
                'pid'=>$data['pid'],
                'menu_event_type'=>$data['menu_event_type'],
                'menu_content'=>$data['menu_content'],
                'sort'=>$data['sort'],               
            ]);
            if($result){
                return ['success'=>true];
            }else{     
                return ['success'=>false];
            }
        }else{
            $data=$wxmenu->get();           
            $menu_list =getTrees($data,0,'menu_id','pid'); 
            return view('admin.wxmenu.edit',compact('menu_list','wxmenu'));
        }
    }
    //发布菜单
    public function pull(){

    }
}
