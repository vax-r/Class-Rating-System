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
        <script>
            $(function(){
                var len = 50; // 超過50個字以"..."取代
                $(".JQellipsis").each(function(i){
                    if($(this).text().length>len){
                        $(this).attr("title",$(this).text());
                        var text=$(this).text().substring(0,len-1)+"...";
                        $(this).text(text);
                    }
                });
            });
        </script>
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
            
            @if(Session::has("alert"))
            <script>
                alert("{{ session()->get('alert') }}");
            </script>
            @endif

            <br>
            <h2 class="text-center">搜尋課程</h2>
            
            <div class="container-sm">
                <figure class="text-end">
                    <blockquote class="blockquote">
                        <p class="text-end">使用者: {{ Session::get('user_name') }}</p>
                    </blockquote>
                </figure>

                <form action="" method="get">
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">請輸入課程名稱</span>
                        <input type="text" class="form-control" name="query" maxlength="20" aria-label="rating" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="d-grid gap-2 col-1 mx-auto">
                        <button type="submit" class="btn btn-outline-primary">搜尋</button>
                    </div>
                </form>

                <br>
                <h3>搜尋結果:</h3>
                @forelse($classes as $class)
                <div class="card border-dark mb-3 text-center">
                    <div class="card-header">
                        課號: {{ $class->class_id }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">課程名稱:{{ $class->class_name }}</h5>
                        <p class="card-text JQellipsis">課程綱要: {{ $class->outline }}</p>
                        <a href="{{ route( 'show_single_class' , $class->class_id ) }}" class="btn btn-primary">完整課程資訊</a>
                        @if(Session::get("privilege") == 1)
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <a href="{{ route('edit_classInfo' , $class->id) }}" class="btn btn-outline-success">Edit</a>
                            <form action="{{ route('delete_classInfo' , $class->id) }}" method="post">
                                @csrf
                                @method("delete")
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('確認刪除?')">Delete</button>
                            </form>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer text-muted">
                        課程評價: {{ $class->rating }}/5
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: {{ $class->rating *20 }}%" aria-valuenow="{{ $class->rating }}" aria-valuemin="0" aria-valuemax="5"></div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="card">
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                        <p>查無資訊</p>
                        </blockquote>
                    </div>
                </div>
                @endforelse

            </div>

        </div>
    </body>


</html>
