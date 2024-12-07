<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * $fillable 属性用来指定哪些字段可以被批量赋值。
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * $hidden 属性用来指定哪些字段在 API 响应中隐藏。
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * $casts 属性用来指定数据库字段使用的数据类型。
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 定义关系 - 一个用户有多条微博
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /**
     * 获取用户的微博 feed。
     */
    public function feed()
    {
        return $this->statuses()->orderBy('created_at', 'desc');
    }

    /**
     * boot() 方法用来监听模型事件，比如创建、更新、删除。
     */
    public static function boot()
    {
        parent::boot();

        // 监听模型创建事件，生成激活码
        static::creating(function ($user) {
            $user->activation_token = md5($user->email . microtime());
        });
    }

    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->email)));
        return "https://cdn.v2ex.com/gravatar/$hash?s=$size";
    }
}
