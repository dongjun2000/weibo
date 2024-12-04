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

    function showResetForm($token)
    {
        // return view('auth.passwords.reset', compact('token'));
    }
}
