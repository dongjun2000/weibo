<a href="{{ route('users.followings', $user)}}">
  <strong id="following" class="stats">{{ $user->followings()->count() }}</strong>
  关注
</a>

<a href="{{ route('users.followers', $user)}}">
  <strong id="followers" class="stats">{{ $user->followers()->count() }}</strong>
  粉丝
</a>

<a href="{{ route('users.show', $user)}}">
  <strong id="statuses" class="stats">{{ $user->statuses()->count() }}</strong>
  微博
</a>
