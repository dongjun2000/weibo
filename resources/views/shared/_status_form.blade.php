<form action="{{ route('statuses.store') }}" method="post">
  @csrf

  <textarea class="form-control" name="content" id="content" rows="3" placeholder="聊聊新鲜事~">{{ old('content')}}</textarea>
  <div class="text-end">
    <button type="submit" class="btn btn-primary mt-3">发布</button>
  </div>
</form>
