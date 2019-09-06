<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    //首页
    Route::get('/index','IndexController@index');
    Route::get('/welcome','IndexController@welcome');
    //登录注册
    Route::get('/login', 'LoginController@login');
    Route::get('/register', 'LoginController@register');//注册
    Route::post('/login', 'LoginController@dologin');//去登录
    Route::get('/lgout','LoginController@lgout');//退出
    //管理员列表
    Route::match(['get','post'],'/users','UsersController@index');
    Route::match(['get','post'],'/users/add','UsersController@add');
    Route::post('/users/{users}','UsersController@setStatus');
    Route::match(['get','post'],'/users/edit/{users}','UsersController@editUsers');
    Route::post('/users/delete/{users}','UsersController@delete');
    //角色管理
    Route::get('/roles','RolesController@index');
    Route::match(['get','post'],'/roles/add','RolesController@addRoles');
    Route::match(['get','post'],'/roles/edit/{roles}','RolesController@edit');
    Route::get('/roles/del/{roles}','RolesController@del');
    //权限管理
    Route::get('/permission','PermissionController@index');
    Route::match(['get','post'],'/permission/add','PermissionController@add');
    Route::match(['get','post'],'/permission/edit/{permission}','PermissionController@edit');
    Route::get('/permission/del/{permission}','PermissionController@del');
    //会员等级
    Route::get('/memslevel','MemsLevelController@index');
    Route::match(['get','post'],'/memslevel/add','MemsLevelController@add');
    Route::match(['get','post'],'/memslevel/edit/{memslevel}','MemsLevelController@edit');
    Route::get('/memslevel/del/{memslevel}','MemsLevelController@del');
    //会员管理
    Route::match(['get','post'],'/members','MembersController@index');
    Route::match(['get','post'],'/members/add','MembersController@add');
    Route::match(['get','post'],'/members/edit/{members}','MembersController@edit');
    Route::post('/members/del/{members}','MembersController@del');
    //网站设置
    Route::get('/website','WebsiteController@index');
    Route::post('/website/img','WebsiteController@upImg');
    Route::post('/website/add/{website}','WebsiteController@add');
    //微信设置
    Route::get('/wxmenu','WxMenuController@index');
    Route::match(['get','post'],'/wxmenu/add','WxmenuController@add');
    Route::match(['get','post'],'/wxmenu/edit/{wxmenu}','WxmenuController@edit');
    Route::get('/wxmenu/pullmenu','WxmennuController@pull');
});
//微信配置
Route::group(['prefix'=>'wechat','namespace'=>'Wechat'],function(){
    Route::get('/index','WechatController@index');   
    Route::post('/index','WechatController@getMessage');   
    Route::get('/token','WechatController@access_token');   
    Route::get('/menu','WechatController@MenuGet');   
    Route::match(['get','post'],'/wxlogin','WechatController@wx_login');   
});