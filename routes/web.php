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
Route::get("/show_users",["as" => "show_users" , "uses" => "App\Http\Controllers\UserController@show_users"]);//管理使用者頁面
Route::put("/{id}/change_privilege", ["as" => "change_privilege" , "uses" => "App\Http\Controllers\UserController@change_privilege"]);//更改使用者權限
Route::get("/change_password_page", ["as" => "change_password_page" , "uses" => "App\Http\Controllers\UserController@change_password_page"]);//更改密碼頁面
Route::put("/change_password", ["as" => "change_password" , "uses" => "App\Http\Controllers\UserController@change_password"]);//更改密碼

Route::get("/homepage",["as" => "homepage" , "uses" => "App\Http\Controllers\SystemController@homepage"]);//首頁

Route::get("/announcement_post",["as" => "announcement_post" , "uses" => "App\Http\Controllers\AnnouncementController@post_announcement"]);//新增公告頁面
Route::post('/store_announcement',["as" => "store_announcement" , "uses" => "App\Http\Controllers\AnnouncementController@store_announcement"]);//發布公告
Route::get('/show_announcement',["as" => "show_announcement" , "uses" => "App\Http\Controllers\AnnouncementController@show_announcement"]);//公告專區
Route::get("/{id}/show_single_announcement",["as" => "show_single_announcement" , "uses" => "App\Http\Controllers\AnnouncementController@show_single_announcement"]);//完整公告內容
Route::get("/{id}/edit_announcement",["as" => "edit_announcement" , "uses" => "App\Http\Controllers\AnnouncementController@edit_announcement"]);//編輯公告的頁面
Route::put("/{id}/update_announcement",["as" => "update_announcement" , "uses" => "App\Http\Controllers\AnnouncementController@update_announcement"]);//編輯公告
Route::delete("/{id}/delete_announcement",["as" => "delete_announcement" , "uses" => "App\Http\Controllers\AnnouncementController@delete_announcement"]);//刪除公告


Route::get("/add_classInfo",["as" => "add_classInfo" , "uses" => "App\Http\Controllers\classInfoController@add_classInfo"]);//新增課程頁面
Route::post('/store_classInfo',["as" => "store_classInfo" , "uses" => "App\Http\Controllers\classInfoController@store_classInfo"]);//新增課程
Route::get('/show_all_class',["as" => "show_all_class" , "uses" => "App\Http\Controllers\classInfoController@show_all_class"]);//課程專區頁面
Route::get('/{class_id}/show_single_class',["as" => "show_single_class" , "uses" => "App\Http\Controllers\classInfoController@show_single_class"]);//完整課程資訊頁面
Route::get("/{id}/edit_classInfo",["as" => "edit_classInfo" , "uses" => "App\Http\Controllers\classInfoController@edit_classInfo"]);//編輯課程資訊頁面
Route::put("/{id}/update_classInfo",["as" => "update_classInfo" , "uses" => "App\Http\Controllers\classInfoController@update_classInfo"]);//編輯課程資訊
Route::delete("/{id}/delete_classInfo",["as" => "delete_classInfo" , "uses" => "App\Http\Controllers\classInfoController@delete_classInfo"]);//刪除課程資訊
Route::get("/show_leaderboard",["as" => "show_leaderboard" , "uses" => "App\Http\Controllers\classInfoController@show_leaderboard"]);//顯示排行榜
Route::get("/show_search",["as" => "show_search" , "uses" => "App\Http\Controllers\classInfoController@show_search"]);//顯示搜尋頁面

Route::post('/{class_id}/store_rating',["as" => "store_rating" , "uses" => "App\Http\Controllers\classRatingController@store_rating"]);//評鑑課程
Route::get("/{id}/edit_classRating",["as" => "edit_classRating" , "uses" => "App\Http\Controllers\classRatingController@edit_classRating"]);//編輯評論頁面
Route::put("/{id}/update_classRating",["as" => "update_classRating" , "uses" => "App\Http\Controllers\classRatingController@update_classRating"]);//編輯評論
Route::delete("/{id}/delete_classRating" , ["as" => "delete_classRating" , "uses" => "App\Http\Controllers\classRatingController@delete_classRating"]);//刪除評論