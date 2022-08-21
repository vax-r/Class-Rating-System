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
                                <li><a class="dropdown-item" href="{{ route('change_password_page') }}">更改密碼</a></li>
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
            <div class="container-sm">
                <h2 class="text-center">更改密碼</h2>
                <br>
                <figure class="text-end">
                    <blockquote class="blockquote">
                        <p class="text-end">使用者: {{ Session::get('user_name') }}</p>
                    </blockquote>
                </figure>
                <br>

                <form action="{{ route('change_password') }}" method="post">
                    @csrf
                    @method("put")
                    <div class="form-group">
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Current Password</span>
                            <input type="password" class="form-control" name="old_password" placeholder="請輸入當前密碼" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{3,8}" aria-label="old_password" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">New Password</span>
                            <input type="password" class="form-control" name="new_password" placeholder="請輸入新密碼" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{3,8}" aria-label="new_password" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Verify your Password</span>
                            <input type="password" class="form-control" name="verify_new_password" placeholder="請再次輸入新密碼" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{3,8}" aria-label="verify_new_password" aria-describedby="basic-addon1" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-outline-primary btn-lg">更改</button>
                    </div>
                </form>
            </div>
        </div>
    </body>

</html>