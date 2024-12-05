<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    // 忘记密码页面
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // 发送重置密码链接
    public function sendResetLinkEmail(Request $request)
    {
        // 验证邮箱格式
        $request->validate(['email' =>'required|email']);
        $email = $request->email;

        // 获取对应的用户
        $user = User::where('email', $email)->first();

        // 如果用户不存在
        if (is_null($user)) {
            session()->flash('danger', '邮箱未注册!');
            return redirect()->back()->withInput();
        }

        // 生成重置密码的 token
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));

        // 保存 token 到数据库
        DB::table('password_resets')->updateOrInsert(['email' => $email], [
            'email' => $email,
            'token' => Hash::make($token),      // Hash::make() 加密 token
            'created_at' => new Carbon(),
        ]);

        // 发送重置密码的邮件
        Mail::send('emails.reset_link', compact('token'), function ($message) use ($email) {
            $message->to($email)->subject('重置密码');
        });

        session()->flash('success', '重置密码邮件已发送，请注意查收');
        return redirect()->back();
    }

    /**
     * 重置密码页面
     * @param $token 重置密码的 token 值
     */
    function showResetForm($token)
    {
        return view('auth.passwords.reset', compact('token'));
    }

    /**
     * 重置密码操作
     * @param Request $request 表单数据
     */
    public function reset(Request $request)
    {
        // 验证表单数据
        $this->validate($request, [
            'token' => 'required',
            'email' =>'required|email',
            'password' =>'required|string|min:6|confirmed'
        ]);
        $token = $request->token;
        $email = $request->email;

        // 获取对应用户
        $user = User::where('email', $email)->first();

        // 如果用户不存在
        if (is_null($user)) {
            session()->flash('danger', '邮箱未注册!');
            return redirect()->back()->withInput();
        }

        // 读取重置的记录
        $tokenRecord = DB::table('password_resets')->where('email', $email)->first();

        // 如果 token 记录不存在
        if (is_null($tokenRecord)) {
            session()->flash('danger', '未找到重置记录!');
            return redirect()->back();
        }

        // 检查 token 是否过期
        $expires = 60 * 100; // 10 分钟
        if (Carbon::parse($tokenRecord->created_at)->addSeconds($expires)->isPast()) {
            session()->flash('danger', '重置密码链接已过期!');
            return redirect()->back();
        }

        // 检查 token 是否正确
        if (! Hash::check($token, $tokenRecord->token)) {
            session()->flash('danger', '重置密码链接无效!');
            return redirect()->back();
        }

        // 更新用户密码
        $user->update(['password' => bcrypt($request->password)]);
        session()->flash('success', '密码重置成功，请使用新密码登录!');
        return redirect()->route('login');
    }
}
