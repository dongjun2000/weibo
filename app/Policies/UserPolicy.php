<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 授权策略：只有当前用户和要修改的用户是同一个人时才允许修改
     *
     * @param User $currentUser 当前用户
     * @param User $user 要修改的用户
     * @return bool 允许修改返回true, 否则返回false
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
