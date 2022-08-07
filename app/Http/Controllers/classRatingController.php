<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use DB;
use App\Models\Announcement;
use App\Models\classInfo;
use App\Models\classRating;

class classRatingController extends Controller
{
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

    public function edit_classRating($id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        
        $class_rating = classRating::find($id);
        $class_info = classInfo::where("class_id",$class_rating->class_id)->get();
        if(session("privilege")!==1 && session("user_name")!==$class_rating->commenter){//如果只是普通使用者並嘗試更改他人的公告
            return \Redirect::back()->with("warning","權限不足");
        }
        return view("class_rate_view.classes.edit_rating")->with("class_rating",$class_rating)->with("class_info",$class_info);
    }

    public function update_classRating($id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        $class_rating = classRating::find($id);
        if(session("privilege")!==1 && session("user_name")!==$class_rating->commenter){//如果只是普通使用者並嘗試更改他人的公告
            return \Redirect::back()->with("warning","權限不足");
        }
        $class_rating->rating = Request::get("rating");
        $class_rating->comment = Request::get("comment");
        $class_rating->save();

        //重新計算平均評分
        $count = classRating::where("class_id",$class_rating->class_id)->count();
        $old_rating = classRating::where("class_id",$class_rating->class_id)->sum("rating");
        $class = classInfo::where("class_id",$class_rating->class_id)->get();
        if($count===0){
            $class[0]->rating=0;
        }
        else{
            $new_rating = (double)($old_rating)/(double)$count;
            $class[0]->rating = $new_rating;
        }
        
        $class[0]->save();

        return redirect(url()->previous())->with("message","編輯成功");//返回上一頁
    }

    public function delete_classRating($id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        $class_rating = classRating::find($id);
        if(session("privilege")!==1 && session("user_name")!==$class_rating->commenter){//如果只是普通使用者並嘗試更改他人的公告
            return \Redirect::back()->with("warning","權限不足");
        }
        classRating::destroy($id);

        //重新計算平均評分
        $count = classRating::where("class_id",$class_rating->class_id)->count();
        $old_rating = classRating::where("class_id",$class_rating->class_id)->sum("rating");
        $class = classInfo::where("class_id",$class_rating->class_id)->get();
        if($count===0){
            $class[0]->rating=0;
        }
        else{
            $new_rating = (double)($old_rating)/(double)$count;
            $class[0]->rating = $new_rating;
        }
        
        $class[0]->save();

        return \Redirect::back()->with("message","刪除成功");
    }
}
