<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
class PermissionController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     * @Description权限列表
     * @example
     * @author liu
     * @since
     */
    public function index(Permission $permission){
        $data=$permission->with(['permiss'])->get(); 
        $per_list = getTree($data,0);      
        return view('admin.permission.index',compact('per_list'));
    }
    public function add(Request $request,Permission $permission){
        if($request->isMethod('post')){
            $data=$request->all();
            $result=$permission->create([
                'act_name'=>$data['act_name'],
                'act_c'=>$data['act_c'],
                'act_m'=>$data['act_m'],
                'act_r'=>$data['act_r'],
                'act_icon'=>$data['act_icon'],
                'pid'=>$data['pid'],
            ]);
            if($result){
                return ['success'=>true];
            }else{     
                return ['success'=>false];
            }
        }else{
            $data=$permission->get();           
            $act_list = getTree($data,0); 
            return view('admin.permission.add',compact('act_list'));
        }
        
    }
    public function edit(Request $request,Permission $permission){
        if($request->isMethod('post')){
            $data=$request->all();
            $result=$permission->update([
                'act_name'=>$data['act_name'],
                'act_c'=>$data['act_c'],
                'act_m'=>$data['act_m'],
                'act_r'=>$data['act_r'],
                'act_icon'=>$data['act_icon'],
                'pid'=>$data['pid'],
            ]);
            if($result){
                return ['success'=>true];
            }else{     
                return ['success'=>false];
            }
        }else{
            $data=$permission->get();           
            $act_list = getTree($data,0); 
            return view('admin.permission.edit',compact('act_list','permission'));
        }
        
    }
    public function del(Permission $permission){
        $result=$permission->delete();
        if($result){
            return ['success'=>true];
        }else{
            return ['success'=>false];
        }
    }
}
