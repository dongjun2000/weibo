@extends('layouts.default')

@section('title', '404 Not Found')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="error-template">
        <h1>
            Sorry!</h1>
        <h2>
            404 Not Found</h2>
        <div class="error-details">
            您访问的页面不存在。
        </div>
        <div class="error-actions mt-3">
            <a href="{{ route('home') }}" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                返回首页 </a>
        </div>
    </div>
  </div>
</div>
@stop
