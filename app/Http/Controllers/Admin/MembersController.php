<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Members;
use App\Models\Memslevel;

class MembersController extends Controller {

    public function index(Request $request,Members $members) {
         if($request->isMethod('post')){            
             //B. 排序
             $n = $request -> input('order.0.column');//获得排序字段的序号
             $duan = $request -> input('columns.'.$n.'.data');//获得排序的字段
             $xu = $request -> input('order.0.dir');  //排序的顺序asc/desc
            //数据分页
            $offset=$request->input('start');//开始
            $len=$request->input('length');//长度偏移量  
            $where=array();                      
            $datemin=$request->input('datemin')?$request->input('datemin'):date("Y-m-d");
            $datemax=$request->input('datemax')?$request->input('datemax'):date("Y-m-d");
            $datemin=$datemin." 00:00:00";
            $datemax=$datemax." 23:59:59"; 
            if($request->input('user_tel')){
                $keyword=$request->input('user_tel');
                $where[]=["user_tel",'like',"%$keyword%"];
            }     
            //获取管理员记录总条数
            $cnt =  $members::where($where) 
                        ->whereBetween('created_at',[$datemin,$datemax])
                        ->count();      
            $shuju=$members::offset($offset)
                ->orderBy($duan,$xu)
                ->where($where) 
                ->whereBetween('created_at',[$datemin,$datemax])              
                ->limit($len)
                ->get();
            $info=[
                'draw'=>$request->get('draw'),
                'recordsTotal'=>$cnt,
                'recordsFiltered'=>$cnt,
                'data'=>$shuju,
            ];
            return $info;
        }else{
            $datemin=date('Y-m-d');
            $datemax=date('Y-m-d');
            return view('admin.members.index',compact('datemin','datemax'));
        }
    }

    //添加会员
    public function add(Request $request, Members $members) {
        if ($request->isMethod("post")) {
            $data = $request->all();
            $form_data = [
                'user_name' => $data['user_name'],
                'user_password' => md5($data['user_password']),
                'real_password' => $data['user_password'],
                'user_tel' => $data['user_tel'],
                'user_email' => $data['user_email'],
                'members_level' => $data['members_level'],
                'sex' => $data['sex'],
            ];
            $result = $members->create($form_data);
            if ($result) {
                return ['success' => true];
            } else {
                return ['success' => false, 'errorinfo' => '添加失败!'];
            }
        } else {
            $memslevel = new MemsLevel();
            $level = $memslevel::orderBy('level_id', 'ASC')->get();
            return view('admin.members.add', compact(['level']));
        }
    }
    //编辑会员
    public function edit(Request $request, Members $members){
          if ($request->isMethod("post")) {
            $data = $request->all();
            $form_data = [
                'user_name' => $data['user_name'],
                'user_password' => md5($data['user_password']),
                'real_password' => $data['user_password'],
                'user_tel' => $data['user_tel'],
                'user_email' => $data['user_email'],
                'members_level' => $data['members_level'],
                'sex' => $data['sex'],
            ];
            $result = $members->update($form_data);
            if ($result) {
                return ['success' => true];
            } else {
                return ['success' => false, 'errorinfo' => '编辑失败!'];
            }
        } else {
            $memslevel = new MemsLevel();
            $level = $memslevel::orderBy('level_id', 'ASC')->get();
            return view('admin.members.edit', compact(['level','members']));
        }
    }
    //删除
    public function del(Members $members){
        $result=$members->delete();
        if($result){
            return ['success' => true]; 
        }else{
            return ['success' => false, 'errorinfo' => '删除失败!']; 
        }
    }

}
