<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NCU課程評鑑系統</title>
        
        <!-- use boostrap5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    
    </head>

    <body>
    <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('homepage') }}">課程評鑑系統</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                功能
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('show_announcement') }}">公告專區</a></li>
                                <li><a class="dropdown-item" href="{{ route('show_all_class') }}">課程評價專區</a></li>
                                <li><a class="dropdown-item" href="{{ route('show_search') }}">搜尋課程</a></li>
                                <li><a class="dropdown-item" href="{{ route('show_leaderboard') }}">課程排行榜</a></li>
                                @if(Session::get("privilege")!=3)
                                <li><a class="dropdown-item" href="{{ route('announcement_post') }}">發布公告</a></li>
                                <li><a class="dropdown-item" href="{{ route('add_classInfo') }}">新增課程</a></li>
                                @endif
                                @if(Session::get("privilege")==1)
                                <li><a class="dropdown-item" href="{{ route('show_users') }}">管理使用者</a></li>
                                @endif
                            </ul>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                帳戶
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('registerpage') }}">註冊</a></li>
                                <li><a class="dropdown-item" href="#">更改密碼</a></li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">登出</a></li>
                            </ul>
                            </li>
                        </ul>
                    </div>  
                </div>
            </nav>

            <div class="container-sm">
                <br>
                <h3 class="text-center">課程資訊</h3>
            
                @if(Session::has("message"))
                <div class = "alert alert-success" role="alert">{{ Session::get("message") }}</div>
                @endif
                <br>
                <div class = "row border border-dark">
                    <div class = "col border border-dark">課程名稱</div>
                    <div class = "col-10 border border-dark">{{ $class_info[0]->class_name }}</div>
                </div>
                <div class="row border border-dark">
                    <div class = "col border border-dark">課號</div>
                    <div class = "col-10 border border-dark">{{ $class_info[0]->class_id }}</div>
                </div>
                <div class="row border border-dark">
                    <div class = "col border border-dark">授課教師</div>
                    <div class = "col-10 border border-dark">{{ $class_info[0]->teacher }}</div>
                </div>
                <div class="row border border-dark">
                    <div class = "col border border-dark">課程評分</div>
                    <div class = "col-10 border border-dark">{{ $class_info[0]->rating }}</div>
                </div>
                <div class="row border border-dark">
                    <div class = "col border border-dark">必/選修</div>
                    @if($class_info[0]->Required == "R")
                    <div class = "col-10 border border-dark">必修</div>
                    @else
                    <div class = "col-10 border border-dark">選修</div>
                    @endif
                </div>
                <div class="row border border-dark">
                    <div class = "col border border-dark">課程大綱</div>
                    <div class = "col-8 border border-dark" style="word-break:break-all; word-wrap:break-all;">{{ $class_info[0]->outline }}</div>
                </div>
                <br>

                <form action = "{{ route('update_classRating', $class_rating->id ) }}" method="post">
                    @csrf
                    @method("put")
                    <div class="input-group mb-3">
                            <span class="input-group-text bg-primary text-white" id="basic-addon1">評分</span>
                            <input type="number" class="form-control" name="rating" value="{{ $class_rating->rating }}" min="0" max="5" aria-label="rating" aria-describedby="basic-addon1" required>
                    </div>
                    
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white">評語</span>
                        <textarea class="form-control" name="comment" placeholder="僅能輸入100字以下" aria-label="With textarea" maxlength="100" required>{{ $class_rating->comment }}</textarea>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">提交</button>
                </form>

                

                
            </div>


        </div>
    </body>
</html>