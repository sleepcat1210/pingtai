<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Users;
class LoginController extends Controller
{
    /**
     * 登录页面
     */
    public function login() {        
        if(Auth::guard('admin')->check()){
            return redirect('admin/index');
        }
        return view("admin.login.login");
    }
    /*
     * 注册
     */
    public function register() {
        $users = new Users();
        $users->name="admin";
        $users->email="779417387@163.com";
        $users->password=bcrypt("123456");
        $users->save();
    }
    /**
     * 去登录
     */
    public function dologin(Request $request){
        if(Auth::guard('admin')->check()){
            return redirect('admin/index');
        }
        if($request->isMethod('post')){
            //验证规则
           $rules=[
               'name'=>'required',
               'password'=>'required',
               'capcode'=>'required|captcha',
           ];
           //提示
           $notices=[
               'name.required'=>'用户名必须填写',
               'password.required'=>'密码必须填写',
               'capcode.required'=>'验证码必须填写',
               'capcode.captcha'=>'验证码不正确',
           ];
           $validator= \Validator::make($request->all(),$rules,$notices);         
           if($validator->passes()){
            //密码
            $password=$request->input('password');
            $name=$request->input('name');
            if(Auth::guard('admin')->attempt(['name'=>$name,'password'=>$password],$request->input('online'))){
                if(Auth::guard('admin')->check()){
                    return redirect('admin/index');
                }
            }else{
                return redirect('admin/login')
                    ->withErrors(['errorinfo'=>'用户名或密码错误'])
                    ->withInput();
            }
           }else{

               return redirect('admin/login')
                    ->withErrors($validator)
                    ->withInput();
           }

        }
        
    }
    /**
     * 退出
     */
    public function lgout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
