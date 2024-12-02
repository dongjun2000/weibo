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
            session()->flash('success', '欢迎回来，' . Auth::user()->name . '！');
            $fallback = route('users.show', Auth::user());
            return redirect()->intended($fallback);
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
