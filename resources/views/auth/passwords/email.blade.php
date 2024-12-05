@extends('layouts.default')

@section('title', '重置密码')

@section('content')
  <div class="col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">重置密码</h5>
      </div>

      <div class="card-body">

        <form action="{{ route('password.email') }}" method="post">
          @csrf

          <div class="mb-3">
            <label for="email" class="form-label">邮箱地址：</label>
            <input type="text" id="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">

            @if ($errors->has('email'))
             <span class="invalid-feedback">
              <strong>{{ $errors->first('email') }}</strong>
             </span>
            @endif
          </div>

          <div class="mb-3">
            <button type="submit" class="btn btn-primary">发送密码重置邮件</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@stop
