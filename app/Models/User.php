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

    // 粉丝关系 - 一个用户有多个粉丝， 获取粉丝的微博
    public function followers()
    {
        // 第一个参数是关联模型的类名，第二个参数是中间表的表名，第三个参数是当前模型的外键名，第四个参数是关联模型的外键名
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    // 关注关系 - 一个用户有多个关注者，获取关注者的微博
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * 获取用户的微博 feed。
     */
    public function feed()
    {
        $user_ids = $this->followings->pluck('id')->toArray();
        array_push($user_ids, $this->id);
        return Status::whereIn('user_id', $user_ids)->with('user')->orderBy('created_at', 'desc');
    }

    /**
     * 关注用户
     * @param $user_ids 用户 ID 或 ID 数组
     */
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = [$user_ids];
        }
        $this->followings()->sync($user_ids, false);
    }

    /**
     * 取消关注用户
     * @param $user_ids 用户 ID 或 ID 数组
     */
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = [$user_ids];
        }
        $this->followings()->detach($user_ids);
    }

    /**
     * 判断当前用户是否关注了指定用户
     * @param $user_id 用户 ID
     */
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
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
