<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title', '微博') - 让每个人都能记录自己的美好生活！</title>
  <link rel="stylesheet" href="{{ mix('css/app.css')}}">
</head>
<body>

  <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
    <div class="container">
      <a href="/" class="navbar-brand">微博</a>
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item"><a href="/help" class="nav-link">帮助</a></li>
        <li class="nav-item"><a href="#" class="nav-link">登录</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">
    @yield('content')
  </div>
</body>
</html>
