<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use DB;
use App\Models\Announcement;
use App\Models\classInfo;
use App\Models\classRating;

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

    public function store_announcement(){//發布公告

        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }

        if(session("privilege") === 3){//判別權限
            return \Redirect::back()->with("message","權限不足");
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

        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        if(session("privilege") === 3){//判別權限
            return \Redirect::back()->with("message","權限不足");
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
        $comment = classRating::where("class_id",$class_id)->where("commenter",session("user_name"))->first();
        $class_info = classInfo::where("class_id",$class_id)->get();
        $class_comments = classRating::where("class_id",$class_id)->paginate(5);
        return view("class_rate_view.classes.show_single")->with("class_info",$class_info)->with("class_comments",$class_comments)->with("commented",$comment);
    }

    public function show_single_announcement($id){//顯示完整公告內容
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        $announcement = Announcement::find($id);
        return view("class_rate_view.announcement.show_single")->with("announcement",$announcement);
    }

    public function edit_announcement($id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        $announcement = Announcement::find($id);
        if(session("privilege")===3 || (session("privilege")===2 && session("user_name")!==$announcement->announcer)){//如果只是普通使用者或嘗試更改他人的公告
            return \Redirect::back()->with("warning","權限不足");
        }
        return view("class_rate_view.announcement.edit")->with("announcement",$announcement);
    }

    public function update_announcement($id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        $announcement = Announcement::find($id);
        if(session("privilege")===3 || (session("privilege")===2 && session("user_name")!==$announcement->announcer)){//如果只是普通使用者或嘗試更改他人的公告
            return \Redirect::back()->with("warning","權限不足");
        }

        $announcement->title = Request::get("title");
        $announcement->content = Request::get("content");
        $announcement->save();
        return redirect(url()->previous())->with("message","編輯成功");//返回上一頁
    }

    public function delete_announcement($id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        $announcement = Announcement::find($id);
        if(session("privilege")===3 || (session("privilege")===2 && session("user_name")!==$announcement->announcer)){//如果只是普通使用者或嘗試更改他人的公告
            return \Redirect::back()->with("warning","權限不足");
        }
        Announcement::destroy($id);
        return \Redirect::back()->with("message","刪除成功");
    }

    public function store_rating($class_id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        //如果有人想直接從路由重複評論課程，這裡會阻擋
        $commented = classRating::where("class_id",$class_id)->where("commenter",session("user_name"))->first();
        if(!is_null($commented)){
            return \Redirect::back()->with("message","您已評論過此課程");
        }

        classRating::create([
            "class_id" => $class_id,
            "commenter" => session("user_name"),
            "rating" => Request::get("rating"),
            "comment" => Request::get("comment"),
        ]);

        //重新計算平均評分
        $count = classRating::where("class_id",$class_id)->count();
        $old_rating = classRating::where("class_id",$class_id)->sum("rating");
        $new_rating = (double)($old_rating)/(double)$count;

        $class = classInfo::where("class_id",$class_id)->get();
        $class[0]->rating = $new_rating;
        $class[0]->save();

        return \Redirect::back()->with("message","評分成功");
    }
}
