@extends('layouts.index')

@section('title',' ')

@section('form')
  <form action="" method="post">
    @csrf
    <dl>
      <dt>Name</dt>
      <dd>
        <input type="text" name="name">
        <!-- name が空の場合の処理 -->
      </dd>
      <dt>
        Password
      </dt>
      <dd>
        <input type="password" name="password">
        <!-- password が空の場合の処理 -->
      </dd>
      <dt>
        <a href="/index">
          会員登録
        </a>
      </dt>
    </dl>
    <div class="entry_submit">
      <input id="login_buttom" type="submit" value="ログイン">
    </div>
  </form>
@endsection