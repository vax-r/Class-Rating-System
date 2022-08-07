<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use DB;
use App\Models\Announcement;
use App\Models\classInfo;
use App\Models\classRating;

class AnnouncementController extends Controller
{
    public function post_announcement(){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        if(session("privilege") === 3){//判別權限
            return \Redirect::back()->with("message","權限不足");
        }
        return view("class_rate_view.announcement.add");//發布公告頁面
    }

    public function store_announcement(){//發布公告
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        if(session("privilege") === 3){//判別權限
            return \Redirect::back()->with("message","權限不足");
        }
        Announcement::create([
            "announcer" => session("user_name"),
            "title" => Request::get("title"),
            "content" => Request::get("content"),
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
}
