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
                                <li><a class="dropdown-item" href="#">搜尋課程</a></li>
                                <li><a class="dropdown-item" href="#">課程排行榜</a></li>
                                @if(Session::get("privilege")==1 || Session::get("privilege")==2)
                                <li><a class="dropdown-item" href="{{ route('announcement_post') }}">發布公告</a></li>
                                <li><a class="dropdown-item" href="{{ route('add_classInfo') }}">新增課程</a></li>
                                @endif
                                @if(Session::get("privilege")==1)
                                <li><a class="dropdown-item" href="#">管理使用者</a></li>
                                @endif
                            </ul>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                帳戶
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                <li><a class="dropdown-item" href="{{ route('registerpage') }}">註冊</a></li>
                                <li><a class="dropdown-item" href="{{ route('loginpage') }}">登入</a></li>
                            </ul>
                            </li>
                        </ul>
                    </div>  
                </div>
            </nav>
            
            <div class="container-sm">
                <h2 class="text-center">NCU課程評鑑系統</h2>
                <h3><small class="text-muted">登入介面</small></h3>
                @if(Session::has("message"))
                <div class = "alert alert-success" role="alert">{{ Session::get("message") }}</div>
                @elseif(Session::has("warning"))
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>{{ Session::get("warning")}}</div>
                </div>
                @endif

                <br>
                <form action = " {{ route('login') }} " method="post">
                    @csrf
                    <div class = "mb-3">
                        <label for="user_name" class="form-label">User Name</label>
                        <input type = "user_name" class="form-control" name="user_name" id="user_name" placeholder="(allow only numbers & english letters, maximum length is 15)" pattern="[a-zA-Z0-9]+" max-length="15" required>
                    </div>
                    <div class = "mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type = "password" class="form-control" name="password" id="password" placeholder="(allow only numbers & english letters, maximum length is 8)" pattern="[a-zA-Z0-9]+" max-length="8" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">登入</button>
                    <br><br>
                    <small class="text-muted">未有帳號?   </small>
                    <button type="button" class="btn btn-warning"><a href = "{{ route('registerpage') }}">註冊</a></button>
                </form>
            </div>

        </div>



    </body>



</html>