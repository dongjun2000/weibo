@extends('layouts.default')

@section('title', '403 Forbidden')

@section('content')
<h1>未授权的操作！</h1>
<p>您没有权限访问此页面！</p>
<p>回到<a href="{{ route('home') }}">首页</a></p>
@stop
