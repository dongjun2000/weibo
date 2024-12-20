<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
  <div class="container">
    <a href="{{ route('home') }}" class="navbar-brand">微博</a>
    <ul class="navbar-nav justify-content-end">

      @if(Auth::check())
        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">用户列表</a></li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a href="{{ route('users.show', Auth::user()) }}" class="dropdown-item">个人中心</a>
            <a href="{{ route('users.edit', Auth::user())}}" class="dropdown-item">编辑资料</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item" id="logout">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
              </form>
            </a>
          </div>
        </li>
      @else
        <li class="nav-item"><a href="{{ route('help') }}" class="nav-link">帮助</a></li>
        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">登录</a></li>
      @endif

    </ul>
  </div>
</nav>
