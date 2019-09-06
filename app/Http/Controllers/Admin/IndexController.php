<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\Users;
class IndexController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     * @Description 首页
     * @example
     * @author liu
     * @since
     */
    public function index(){
        $user_id=Auth::guard('admin')->user()->id;
        $role_ids=Users::find($user_id)->roles->act_list;
        $role_ids=explode(',',$role_ids);        
        $permission=new Permission();
        $data=$permission->whereIn('act_id',$role_ids)->get();
        $per_list=$data->toArray();
        $per_list=generateTree($per_list);       
        return view('admin.index.index',compact('per_list'));
    }
    public function welcome(){
        return view('admin.index.welcome');
    }
}
