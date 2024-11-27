<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 静态页面路由
Route::get('/', 'StaticPagesController@home')->name('home');      // 首页
Route::get('/help', 'StaticPagesController@help')->name('help');    // 帮助
Route::get('/about', 'StaticPagesController@about')->name('about');    // 关于
Route::get('/contact', 'StaticPagesController@contact')->name('contact');    // 联系我们

Route::get('/signup', 'UsersController@create')->name('signup');    // 注册页面

Route::resource('users', 'UsersController');    // 用户资源路由
