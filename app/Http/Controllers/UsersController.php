<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        // 除了 show、create、store 以外的都需要登录才能访问
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store']
        ]);

        // 已登录的用户不能访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    // 所有用户列表
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // 注册页面
    public function create()
    {
        return view('users.create');
    }

    // 个人中心
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // 注册逻辑
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        return redirect()->route('users.show', [$user]);
    }

    // 编辑个人资料页面
    public function edit(User $user)
    {
        // 授权 - 只有当前登录用户才能编辑自己的资料
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    // 更新个人资料
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'    // nullable：密码可以为空
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功!');

        return redirect()->route('users.show', [$user]);
    }
}
