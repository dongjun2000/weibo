<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        // 除了 show, create, store, index, confirmEmail 都需要登录才能访问
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);

        // 已登录的用户不能访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);

        // 限流
        $this->middleware('throttle:10,60', [
            'only' => ['store']
        ]);
    }

    // 所有用户列表
    public function index()
    {
        $users = User::paginate(6);    // 分页
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
        $statuses =$user->statuses()->orderBy('created_at', 'desc')->paginate(30);

        return view('users.show', compact('user', 'statuses'));
    }

    // 关注列表
    public function followings(User $user)
    {
        $users = $user->followings()->paginate(30);
        $title = $user->name . '关注的人';
        return view('users.show_follow', compact('users', 'title'));
    }

    // 粉丝列表
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(30);
        $title = $user->name . '的粉丝';
        return view('users.show_follow', compact('users', 'title'));
    }

    // 关注用户
    public function follow(User $user)
    {

    }

    // 取消关注用户
    public function unfollow(User $user)
    {

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

        $this->sendEmailConfirmationTo($user);  // 发送邮件确认邮件

        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');

        return redirect()->route('home');
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

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '用户删除成功!');
        return back();
    }

    /**
     * 验证邮箱
     * @param $token string 邮箱验证 token
     */
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();     // 根据 token 找出用户， firstOrFail() 确保用户存在, 否则抛出异常

        // 验证用户是否已激活
        $user->activated = true;        // 标记为已激活
        $user->activation_token = null; // 清空 token
        $user->save();

        Auth::login($user); // 登录用户
        session()->flash('success', '邮箱验证成功!');
        return redirect()->route('users.show', [$user]);
    }

    /**
     * 发送验证邮件
     * @param User $user 用户实例
     */
    private function sendEmailConfirmationTo(User $user)
    {

        $view = 'emails.confirm';     // 邮件模板
        $data = compact('user');    // 邮件数据
        $to = $user->email; // 收件人
        $subject = '感谢注册 微博 应用！请确认您的邮箱';    // 邮件主题

        // 发送邮件
        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }
}
