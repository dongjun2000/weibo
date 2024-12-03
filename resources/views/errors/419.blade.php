@extends('layouts.default')

@section('title', '419 您已退出登录')

@section('content')
    <div class="row">
      <div class="col-md-12">
        <div class="error-template">
            <h1>
                Oops!</h1>
            <h2>
                419 您已退出登录</h2>
            <div class="error-details">
                您已经退出登录，请重新登录。
            </div>
            <div class="error-actions mt-3">
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                    返回首页 </a>
            </div>
        </div>
      </div>
    </div>
@endsection
