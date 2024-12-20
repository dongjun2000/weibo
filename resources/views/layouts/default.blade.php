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
  @include('layouts._header')

  <div class="container">
    @include('shared._messages')

    @yield('content')

    @include('layouts._footer')
  </div>

  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
