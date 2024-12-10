@extends('layouts.default')

@section('title', '主页')

@section('content')
@if (Auth::check())
  <div class="row">
    <div class="col-md-8">
      <section class="status_form">
        @include('shared._status_form')
      </section>
      <h4>微博列表</h4>
      <hr>
      @include('shared._feed')
    </div>
    <aside class="col-md-4">
      <section class="user_info">
        @include('shared._user_info', ['user' => Auth::user()])
      </section>
      <section class="stats mt-2">
        @include('shared._stats', ['user' => Auth::user()])
      </section>
    </aside>
  </div>
@else
  <div class="bg-light p-3 p-sm-5 rounded">
    <h1>欢迎来到微博</h1>
    <p class="lead">
      微博是一个基于 Laravel 框架开发的微博系统，你可以在这里发布你的想法、记录你的生活。
    </p>
    <p>
      一切，将从这里开始。
    </p>
    <p>
      <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
    </p>
  </div>
@endif
@stop
