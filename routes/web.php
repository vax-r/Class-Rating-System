<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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


Route::get('/',["as" => "loginpage" , "uses" => "App\Http\Controllers\UserController@loginpage"]);//登入頁面
Route::post('/login',["as" => "login" , "uses" => "App\Http\Controllers\UserController@login"]);//登入驗證
Route::get('registerpage',["as" => "registerpage" , "uses" => "App\Http\Controllers\UserController@registerpage"]);//註冊頁面
Route::post('/register',["as" => "register" , "uses" => "App\Http\Controllers\UserController@register"]);//註冊驗證
Route::get("/logout",["as" => "logout" , "uses" => "App\Http\Controllers\UserController@logout"]);//登出
Route::get("/homepage",["as" => "homepage" , "uses" => "App\Http\Controllers\SystemController@homepage"]);//首頁

Route::get("/announcement_post",["as" => "announcement_post" , "uses" => function(){
    if(!session()->exists("user_name")){
        return redirect("/")->with("warning","請先登入");
    }
    return view("class_rate_view.announcement.add");//發布公告頁面
}]);
Route::post('/store_announcement',["as" => "store_announcement" , "uses" => "App\Http\Controllers\SystemController@store_announcement"]);//發布公告
Route::get('/show_announcement',["as" => "show_announcement" , "uses" => "App\Http\Controllers\SystemController@show_announcement"]);//公告頁面
Route::get("/{id}/show_single_announcement",["as" => "show_single_announcement" , "uses" => "App\Http\Controllers\SystemController@show_single_announcement"]);//完整公告內容
Route::get("/{id}/edit_announcement",["as" => "edit_announcement" , "uses" => "App\Http\Controllers\SystemController@edit_announcement"]);//編輯公告的頁面
Route::put("/{id}",["as" => "update_announcement" , "uses" => "App\Http\Controllers\SystemController@update_announcement"]);//編輯公告
Route::delete("/{id}",["as" => "delete_announcement" , "uses" => "App\Http\Controllers\SystemController@delete_announcement"]);//刪除公告


Route::get("/add_classInfo",["as" => "add_classInfo" , "uses" => function(){
    if(!session()->exists("user_name")){
        return redirect("/")->with("warning","請先登入");
    }
    return view("class_rate_view.classes.add");//新增課程頁面
}]);
Route::post('/store_classInfo',["as" => "store_classInfo" , "uses" => "App\Http\Controllers\SystemController@store_classInfo"]);//新增課程
Route::get('/show_all_class',["as" => "show_all_class" , "uses" => "App\Http\Controllers\SystemController@show_all_class"]);//課程專區頁面
Route::get('/{class_id}/show_single_class',["as" => "show_single_class" , "uses" => "App\Http\Controllers\SystemController@show_single_class"]);//完整課程資訊頁面
Route::post('/{class_id}/store_rating',["as" => "store_rating" , "uses" => "App\Http\Controllers\SystemController@store_rating"]);//評鑑課程