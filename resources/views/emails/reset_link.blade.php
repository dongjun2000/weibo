<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>找回密码</title>
</head>
<body>
  <h1>您正在尝试找回密码</h1>

  <p>
    请点击以下链接进入下一步操作：
    <a href="{{ route('password.reset', $token) }}">
      {{ route('password.reset', $token) }}
    </a>
  </p>

  <p>
    如果链接无法打开，请将它复制到浏览器地址栏中打开。
  </p>

  <p>
    如果这不是您本人的操作，请忽略此邮件。
  </p>
</body>
</html>
