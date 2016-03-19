<?php

require_once __DIR__.'/../Http/example_routes.php';
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//首页
Route::get('/',['as'=>'index',
    'uses'=>'IndexController@index']);


Route::group(['prefix'=>'account'],function(){

    //登录
    Route::get('login',[
        'as'=>'login',
        'uses'=>'AccountController@login'
    ]);
    //登录验证
    Route::post('loginAjax',[
        'as'=>'loginAjax',
        'uses'=>'AccountController@loginAjax'
    ]);
    //用户信息
    Route::get('profile',[
        'as'=>'profile',
        'uses'=>'AccountController@profile'
    ]);
    Route::get('logout',[
        'as'=>'logout',
        'uses'=>'AccountController@logout'
    ]);
    //用户列表
    Route::get('userList',[
        'as'=>'userList',
        'uses'=>'AccountController@userList'
    ]);
    //添加用户
    Route::match(['get','post'],'userAdd',[
        'as'=>'userAdd',
        'uses'=>'AccountController@userAdd'
    ]);
    //删除用户
    Route::match(['get','post'],'userDelete',[
        'as'=>'userDelete',
        'uses'=>'AccountController@userDelete'
    ]);
    //修改用户
    Route::match(['get','post'],'userUpdate',[
        'as'=>'userUpdate',
        'uses'=>'AccountController@userUpdate'
    ]);
    //用户详情
    Route::get('userDetail',[
        'as'=>'userDetail',
        'uses'=>'AccountController@userDetail'
    ]);
    //组列表
    Route::get('roleList',[
        'as'=>'roleList',
        'uses'=>'AccountController@roleList'
    ]);
    //添加组
    Route::match(['get','post'],'roleAdd',[
        'as'=>'roleAdd',
        'uses'=>'AccountController@roleAdd'
    ]);
    //组详情
    Route::get('roleDetail',[
        'as'=>'roleDetail',
        'uses'=>'AccountController@roleDetail'
    ]);
    Route::match(['get','post'],'roleUpdate',[
        'as'=>'roleUpdate',
        'uses'=>'AccountController@roleUpdate'
    ]);
    Route::match(['get','post'],'roleDelete',[
        'as'=>'roleDelete',
        'uses'=>'AccountController@roleDelete'
    ]);
    //权限列表
    Route::get('permissionList',[
        'as'=>'permissionList',
        'uses'=>'AccountController@permissionList'
    ]);
    //权限详情
    Route::get('permissionDetail',[
        'as'=>'permissionDetail',
        'uses'=>'AccountController@permissionDetail'
    ]);
    //添加权限
    Route::match(['get','post'],'permissionAdd',[
        'as'=>'permissionAdd',
        'uses'=>'AccountController@permissionAdd'
    ]);

});

