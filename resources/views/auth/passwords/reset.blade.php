@extends('layouts.default')

@section('title', '重置密码')

@section('content')
  <div class="offset-md-2 col-md-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">重置密码</h5>
      </div>

      <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
          @csrf

          <input type="hidden" name="token" value="{{ $token }}">

          <div class="mb-3">
            <label for="email" class="form-label">邮箱地址：</label>
            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
              <div class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
              </div>
            @endif
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">新密码：</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" name="password">
            @if ($errors->has('password'))
              <div class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
              </div>
              @endif
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">确认密码：</label>
            <input type="password" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" id="password_confirmation" name="password_confirmation">
          </div>

          <button type="submit" class="btn btn-primary">重置密码</button>
        </form>
      </div>
    </div>
  </div>
@stop
