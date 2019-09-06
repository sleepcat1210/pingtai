<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Roles;
class UsersController extends Controller
{
    /**
     * 
     * @param Request $request
     * @return void
     * @Description管理员列表
     * @example
     * @author liu
     * @since
     */
    public function index(Request $request){
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
            if($request->input('keyword')){
                $keyword=$request->input('keyword');
                $where[]=['name','like',"%$keyword%"];
            }     
            //获取管理员记录总条数
            $cnt =Users::where($where) 
                        ->whereBetween('created_at',[$datemin,$datemax])
                        ->count();      
            $shuju=Users::offset($offset)
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
            return view('admin.users.index',compact('datemin','datemax'));
        }
        
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     * @Description添加管理员
     * @example
     * @author liu
     * @since
     */
    public function add(Request $request){
        if($request->isMethod('post')){
           $rules=[
               'name'=>'required',
               'password'=>'required',
               'phone'=>'required',
               'email'=>'required',
               'sex'=>'required',
               'role_id'=>'required',
           ];
           $notices = [
            'name.required'=>'姓名必须填写',
            'password.required'=>'密码必须填写',
            'phone.required'=>'手机号必须填写',
            'email.required'=>'邮箱必须填写',
            'sex.required'=>'性别必须选择',
            'role_id.required'=>'角色必须选择',
        ];
        //收集数据
        $from_data=$request->all();
        $validator=\Validator::make($from_data,$rules,$notices);
        if($validator->passes()){//验证通过
            //储存数据
            Users::create([
                'name'=>$from_data['name'],
                'password'=>bcrypt($from_data['password']),
                'phone'=>$from_data['phone'],
                'sex'=>$from_data['sex'],
                'email'=>$from_data['email'],
                'role_id'=>$from_data['role_id'],
            ]);
            return ['success'=>true];          
        }else{
            $errorinfo=collect($validator->messages())->implode('0','|');
            return ['success'=>false,'errorinfo'=>$errorinfo];           
        }
        }else{
            $roles=Roles::pluck('role_name','role_id')->toArray();           
            return view('admin.users.add',compact('roles'));
        }
        
    }
    /**
     * Undocumented function
     *
     * @param Request $request status 1启用0停止
     * @param Users $users 管理员id
     * @return void
     * @Description 设置管理员启用和停止
     * @example
     * @author liu
     * @since
     */
    public function setStatus(Request $request,Users $users){
        $users->status=$request->input('status');
        $users->update();
        return ['success'=>'设置成功!'];
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Users $users 管理员对象
     * @return void
     * @Description编辑修改管理员
     * @example
     * @author liu
     * @since
     */
    public function editUsers(Request $request,Users $users){
        if($request->isMethod('post')){            
                $rules=[
                    'name'=>'required',
                    'password'=>'required',
                    'phone'=>'required',
                    'email'=>'required',
                    'sex'=>'required',
                    'role_id'=>'required',
                ];
                $notices = [
                 'name.required'=>'姓名必须填写',
                 'password.required'=>'密码必须填写',
                 'phone.required'=>'手机号必须填写',
                 'email.required'=>'邮箱必须填写',
                 'sex.required'=>'性别必须选择',
                 'role_id.required'=>'角色必须选择',
             ];
             //收集数据
             $from_data=$request->all();
             $validator=\Validator::make($from_data,$rules,$notices);
             if($validator->passes()){//验证通过
                 //储存数据
                 $users->update([
                     'name'=>$from_data['name'],
                     'password'=>bcrypt($from_data['password']),
                     'phone'=>$from_data['phone'],
                     'sex'=>$from_data['sex'],
                     'email'=>$from_data['email'],
                     'role_id'=>$from_data['role_id'],
                 ]);
                 return ['success'=>true]; 
                }else{
                    $errorinfo=collect($validator->messages())->implode('0','|');
                    return ['success'=>false,'errorinfo'=>$errorinfo];           
                }
        }else{
            $roles=Roles::pluck('role_name','role_id')->toArray();   
            return view('admin.users.edit',compact('users','roles'));
        }
    }

    public function delete(Request $request,Users $users){
        if($request->isMethod('post')){
            $result=$users->delete();
            if($result){
                return ['success'=>true];
            }else{
                return ['success'=>false];
            }
        }
    }
    
}
