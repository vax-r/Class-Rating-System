<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use DB;
use App\Models\Announcement;
use App\Models\classInfo;
use App\Models\classRating;

class classInfoController extends Controller
{
    public function add_classInfo(){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        if(session("privilege") === 3){//判別權限
            return \Redirect::back()->with("message","權限不足");
        }
        return view("class_rate_view.classes.add");//新增課程頁面
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

    public function edit_classInfo($id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        if(session("privilege")!==1){//如果只是普通使用者或嘗試更改他人的公告
            return \Redirect::back()->with("warning","權限不足");
        }
        $classInfo = classInfo::find($id);
        return view("class_rate_view.classes.edit")->with("classInfo",$classInfo);
    }

    public function update_classInfo($id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        if(session("privilege")!==1){//如果只是普通使用者或嘗試更改他人的公告
            return \Redirect::back()->with("warning","權限不足");
        }
        $classInfo = classInfo::find($id);
        $classInfo->class_id = Request::get("class_id");
        $classInfo->class_name = Request::get("class_name");
        $classInfo->teacher = Request::get("teacher");
        $classInfo->credit = Request::get("credit");
        $classInfo->Required = Request::get("class_type");
        $classInfo->outline = Request::get("outline");
        $classInfo->save();
        return redirect(url()->previous())->with("message","編輯成功");//返回上一頁
    }

    public function delete_classInfo($id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        if(session("privilege")!==1){//如果只是普通使用者或嘗試更改他人的公告
            return \Redirect::back()->with("warning","權限不足");
        }
        $class = classInfo::find($id);
        $collection = classRating::where("class_id" , $class->class_id)->get(['id']);
        classRating::destroy($collection->toArray());//刪除所有相關留言
        classInfo::destroy($id);//刪除此課程
        return \Redirect::back()->with("message","刪除成功");
    }
}
