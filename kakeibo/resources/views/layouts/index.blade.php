<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/index/smart_index_styles.css')}}">
  <link rel="stylesheet" href="{{asset('css/index/tablet_index_styles.css')}}">
  <link rel="stylesheet" href="{{asset('css/index/pc_index_styles.css')}}">
  <title>Login</title>
</head>
<body>
  <div class="login_box">
    <div class="login_title">
      <p>@yield('title')</p>
    </div>
    @yield('form')
  </div>
</body>
</html>