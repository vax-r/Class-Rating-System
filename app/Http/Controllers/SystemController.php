<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use DB;
use App\Models\Announcement;
use App\Models\classInfo;

class SystemController extends Controller
{
    public function homepage(){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        $announcements = Announcement::orderby('id','DESC')->take(3)->get();
        $class_infos = classInfo::orderby('id','DESC')->take(3)->get();
        return view("class_rate_view.homepage")->with("announcements",$announcements)->with("classInfos",$class_infos);
    }

    public function store_announcement(){
        //TODO: 判別使用者權限
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        $user_name = session("user_name");
        $title = Request::get("title");
        $content = Request::get("content");
        Announcement::create([
            "announcer" => $user_name,
            "title" => $title,
            "content" => $content,
        ]);
        return \Redirect::back()->with("message", "留言成功");
    }

    public function show_announcement(){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        
        $announcements = Announcement::orderby('id','DESC')->paginate(5);
        return view("class_rate_view.announcement.show")->with("announcements",$announcements);
    }

    public function store_classInfo(){
        //TODO: 判別使用者權限
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        classInfo::create([
            "class_id" => Request::get("class_id"),
            "class_name" => Request::get("class_name"),
            "teacher" => Request::get("teacher"),
            "credit" => Request::get("credit"),
            "Required" => Request::get("class_type"),
            "outline" => Request::get("outline"),
            "rating" => 0,
        ]);
        return \Redirect::back()->with("message","新增課程成功");
    }

    public function show_all_class(){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }

        $classes = classInfo::orderby('id','DESC')->paginate(5);
        return view("class_rate_view.classes.show_all")->with("classes",$classes);
    }

    public function show_single_class($class_id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        $class_info = classInfo::where("class_id",$class_id)->get();
        return view("class_rate_view.classes.show_single")->with("class_info",$class_info);
    }
}
