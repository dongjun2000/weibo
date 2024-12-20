<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function __construct()
    {
        // 除了登录页面外，其他页面都需要登录才能访问
        $this->middleware('auth', [
            'except' => ['create', 'store']
        ]);

        // 已登录用户不能访问登录页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);

        // 限流
        $this->middleware('throttle:10,10', [
            'only' => ['store']
        ]);
    }

    // 显示登录表单
    public function create()
    {
        return view('sessions.create');
    }

    // 处理登录表单提交
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            // 登录成功
            if (Auth::user()->activated) {    // 判断用户是否激活
                // 已激活用户
                session()->flash('success', '欢迎回来，' . Auth::user()->name . '！');
                return redirect()->intended();
            } else {
                // 未激活用户
                Auth::logout(); // 强制退出
                session()->flash('warning', '您的账号尚未激活，请前往邮箱激活。');
                return redirect('login');
            }
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配。');
            return redirect()->back()->withInput();
        }
    }

    // 退出登录
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
