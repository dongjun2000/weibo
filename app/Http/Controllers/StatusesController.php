<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Status;

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

    /**
     * 删除微博
     * @param Status $status 微博对象
     */
    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被删除成功！');
        return redirect()->back();
    }
}
