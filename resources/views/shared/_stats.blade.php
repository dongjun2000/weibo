<a href="#">
  <strong id="following" class="stats">{{ $user->followings()->count() }}</strong>
  关注
</a>

<a href="#">
  <strong id="followers" class="stats">{{ $user->followers()->count() }}</strong>
  粉丝
</a>

<a href="#">
  <strong id="statuses" class="stats">{{ $user->statuses()->count() }}</strong>
  微博
</a>
