@extends('layouts.default')

@section('title', '用户登录')

@section('content')

    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h5>用户登录</h5>
            </div>
            <div class="card-body">

              @include('shared._errors')

              <form method="POST" action="{{ route('login') }}">
                  @csrf

                  <div class="mb-3">
                      <label for="email">邮箱：</label>
                      <input type="text" name="email" class="form-control" value="{{ old('email') }}" autofocus>
                  </div>
                  <div class="mb-3">
                      <label for="password">密码：</label>
                      <input type="password" name="password" id="password" class="form-control">
                  </div>

                  <button type="submit" class="btn btn-primary">登录</button>
              </form>
            </div>
        </div>
    </div>

@endsection
