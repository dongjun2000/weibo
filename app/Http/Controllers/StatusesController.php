<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 发布微博
     * @param Request $request 请求对象
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' =>'required|max:140'
        ]);

        $user = Auth::user()->statuses()->create([
            'content' => $request->content
        ]);

        session()->flash('success', '发布成功！');

        return redirect()->back();
    }
}
