<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\User;

class UserController extends Controller
{
    public function loginpage(){
        return view("class_rate_view.loginpage");
    }
    
    public function login(){
        $user_name = Request::get("user_name");
        $password = Request::get("password");
        DB::connection("mysql");
        $userData = DB::select("SELECT * FROM users WHERE name=?", [$user_name]);

        if(!isset($userData[0]->name)){
            return \Redirect::back()->with("message","使用者不存在");
        }elseif(password_verify($password, $userData[0]->password)){
            session(["user_name" => $userData[0]->name]);
            session(["privilege" => $userData[0]->privilege]);
            return redirect("/homepage");
        }else{
            return \Redirect::back()->with("message","密碼錯誤");
        }
    }

    public function registerpage(){
        return view("class_rate_view.registerpage");
    }

    public function register(){
        $user_name = Request::get("user_name");
        $password = Request::get("password");
        DB::connection("mysql");
        $userData = DB::select("SELECT * FROM users WHERE name=?", [$user_name]);
        if(isset($userData[0]->name)){
            return \Redirect::back()->with("message","已存在使用者");
        }
        else{
            $hashed_password = Hash::make($password);
            $privilege = 3;
            User::create([
                "name" => $user_name,
                "password" => $hashed_password,
                "privilege" => $privilege,
            ]);
            return \Redirect::back()->with("message","註冊成功");
        }
    }

    public function logout(){
        session()->forget("user_name");
        session()->forget("privilege");
        return redirect("/");
    }
}
