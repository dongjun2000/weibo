@extends('layouts.default')

@section('title', '更新个人资料')

@section('content')
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h5>更新个人资料</h5>
    </div>
    <div class="card-body">

      @include('shared._errors')

      <div class="gravatar_edit">
        <a href="http://gravatar.com/emails" target="_blank" rel="noopener noreferrer">
          <img src="{{ $user->gravatar('200') }}" alt="{{ $user->name}}" class="gravatar">
        </a>
      </div>

      <form action="{{ route('users.update', $user->id) }}" method="post">
        @csrf @method('PATCH')

        <div class="mb-3">
          <label for="name">名称：</label>
          <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>
        <div class="mb-3">
          <label for="email">邮箱：</label>
          <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}" disabled>
        </div>
        <div class="mb-3">
          <label for="password">密码：</label>
          <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="mb-3">
          <label for="password_confirmation">确认密码：</label>
          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
      </form>
    </div>
  </div>
@stop
