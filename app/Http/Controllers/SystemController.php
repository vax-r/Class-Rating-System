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
        $top_classes = classInfo::orderby('rating','DESC')->take(3)->get();
        return view("class_rate_view.homepage")->with("announcements",$announcements)->with("classInfos",$class_infos)->with("top_classes",$top_classes);
    }

}
