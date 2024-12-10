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
Route::get('/signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');    // 确认邮箱

Route::get('/password/reset', 'PasswordController@showLinkRequestForm')->name('password.request');    // 忘记密码页面
Route::post('/password/email', 'PasswordController@sendResetLinkEmail')->name('password.email');    // 发送重置密码邮件
Route::get('/password/reset/{token}', 'PasswordController@showResetForm')->name('password.reset');   // 重置密码页面
Route::post('/password/reset', 'PasswordController@reset')->name('password.update');    // 重置密码提交

Route::get('/login', 'SessionsController@create')->name('login');    // 登录页面
Route::post('/login', 'SessionsController@store')->name('login');    // 登录提交
Route::delete('/logout', 'SessionsController@destroy')->name('logout');    // 退出登录

Route::resource('users', 'UsersController');    // 用户资源路由
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);    // 微博资源路由

Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');    // 关注列表
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');    // 粉丝列表

Route::post('/users/followers/{user}', 'UsersController@follow')->name('users.follow');    // 关注
Route::delete('/users/followers/{user}', 'UsersController@unfollow')->name('users.unfollow');    // 取消关注
