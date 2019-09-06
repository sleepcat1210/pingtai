<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\Permission;
class RolesController extends Controller
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     * @Description角色列表
     * @example
     * @author liu
     * @since
     */
    public function index(Roles $roles){
        $list=$roles->get();
        return view('admin.roles.index',compact('list'));
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Roles $roles
     * @return void
     * @Description添加角色
     * @example
     * @author liu
     * @since
     */
    public function addRoles(Request $request,Roles $roles){
        if($request->isMethod("post")){
         $form_data=$request->all();         
         $result=$roles->create([
             'role_name'=>$form_data['role_name'],
             'role_desc'=>$form_data['role_desc'],
             'act_list'=>empty($form_data['act_id'])? "":implode(',',$form_data['act_id']),
         ]);
         if($result){
            return ['success'=>true];
         }else{
            return ['success'=>false,'errorinfo'=>'添加失败!'];
         }
        }else{
            $permission= new Permission();
            $data=$permission->get();
            $per_list=$data->toArray();
            $per_list=generateTree($per_list);           
            return view("admin.roles.add",compact('per_list'));
        }
       
    }
     /**
     * Undocumented function
     *
     * @param Request $request
     * @param Roles $roles
     * @return void
     * @Description添加角色
     * @example
     * @author liu
     * @since
     */
    public function edit(Request $request,Roles $roles){
        if($request->isMethod("post")){
         $form_data=$request->all();         
         $result=$roles->update([
             'role_name'=>$form_data['role_name'],
             'role_desc'=>$form_data['role_desc'],
             'act_list'=>empty($form_data['act_id'])? "":implode(',',$form_data['act_id']),
         ]);
         if($result){
            return ['success'=>true];
         }else{
            return ['success'=>false,'errorinfo'=>'编辑失败!'];
         }
        }else{
            $permission= new Permission();
            $data=$permission->get();
            $per_list=$data->toArray();
            $per_list=generateTree($per_list);
            $roles_per=explode(',',$roles->act_list);
            return view("admin.roles.edit",compact('roles','per_list','roles_per'));
        }
       
    }
    public function del(Roles $roles){
        $result=$roles->delete();
        if($result){
            return ['success'=>true];
        }else{
            return ['success'=>false];
        }
    }
}
