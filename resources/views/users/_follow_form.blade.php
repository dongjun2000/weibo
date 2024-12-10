@can('follow', $user)
<div class="text-center mt-2 mb-4">
  @if (Auth::user()->isFollowing($user->id))
    <form action="{{ route('users.unfollow', $user) }}" method="post">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-sm btn-outline-primary">取消关注</button>
    </form>
  @else
    <form action="{{ route('users.follow', $user) }}" method="post">
      @csrf
      <button type="submit" class="btn btn-sm btn-primary">关注</button>
    </form>
  @endif
</div>

@endcan
