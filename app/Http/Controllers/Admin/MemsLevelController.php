<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MemsLevel;

class MemsLevelController extends Controller
{
    public function index(MemsLevel $memslevel){
        $list=$memslevel->get();
        return view('admin.memslevel.index',compact(['list']));
    }
    /*
     * 添加等级
     */
    public function add(Request $request,MemsLevel $memslevel){
        if($request->isMethod('post')){
            $form_data=$request->all();
            $result=$memslevel->create([
                'level_name'=>$form_data['level_name'],
                'amount'=>$form_data['amount'],
                'discount'=>$form_data['discount'],
                'describe'=>$form_data['describe'],
            ]);
           if($result){
            return ['success'=>true];
         }else{
            return ['success'=>false,'errorinfo'=>'添加失败!'];
         }
        }else{
             return view('admin.memslevel.add');
        }       
    }
    /*
     * 编辑
     */
    public function edit(Request $request,MemsLevel $memslevel){
        if($request->isMethod('post')){
            $form_data=$request->all();
            $result=$memslevel->update([
                'level_name'=>$form_data['level_name'],
                'amount'=>$form_data['amount'],
                'discount'=>$form_data['discount'],
                'describe'=>$form_data['describe'],
            ]);
           if($result){
            return ['success'=>true];
         }else{
            return ['success'=>false,'errorinfo'=>'修改失败!'];
         }
        }else{            
             return view('admin.memslevel.edit',compact('memslevel'));
        }       
    }
    
    
    //删除
    public function del(MemsLevel $memslevel){
        $result=$memslevel->delete();
        if($result){
            return ['success'=>true];
        }else{
            return ['success'=>false];
        }
    }
}
