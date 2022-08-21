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
            <br>

            <h2 class="text-center">管理使用者</h2>
            <div class="container-sm">
                <figure class="text-end">
                    <blockquote class="blockquote">
                        <p class="text-end">使用者: {{ Session::get('user_name') }}</p>
                    </blockquote>
                </figure>

                @if(Session::has("message"))
                <div class = "alert alert-success" role="alert">{{ Session::get("message") }}</div>
                @endif
                @if(Session::has("alert"))
                <script>
                    alert("{{ session()->get('alert') }}");
                </script>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">用戶名稱</th>
                        <th scope="col">權限</th>
                        <th scope="col">變更權限</th>
                        <th scope="col"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{ $user->name }}</td>
                            @if($user->privilege == 1)
                            <td>管理員</td>
                            @elseif($user->privilege == 2)
                            <td>SuperUser</td>
                            @elseif($user->privilege == 3)
                            <td>一般使用者</td>
                            @else
                            <td>停權</td>
                            @endif
                            <form action="{{ route('change_privilege', $user->id) }}" method="post">
                                @csrf
                                @method("put")
                                <td>
                                    <select class="form-select form-select-sm" name="privilege" aria-label=".form-select-sm example">
                                        <option selected value="0">選擇</option>
                                        <option value="1">管理員</option>
                                        <option value="2">Super User</option>
                                        <option value="3">一般使用者</option>
                                        <option value="-1">停權</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-secondary">更改</button>
                                </td>
                            </form>
                        </tr>
                        @empty
                        <tr>
                            <th scope="row">1</th>
                            <th>尚未有使用者</th>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
    </body>
</html>
