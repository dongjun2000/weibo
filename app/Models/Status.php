<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    // 定义与用户模型的关联 - 一条微博对应一个用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
