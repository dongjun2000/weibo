<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取所有用户
        $users = User::all();
        // 取出第一个用户
        $user = $users->first();
        $user_id = $user->id;

        // 取出除第一个用户外的所有用户
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        // 第一个用户关注除第一个用户外的所有用户
        $user->follow($follower_ids);

        // 除第一个用户外的所有用户关注第一个用户
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}
