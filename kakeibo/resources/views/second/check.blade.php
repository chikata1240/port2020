@extends('layouts.index')

@section('title','入力確認')

@section('form')
  <form action="/thanks" method="POST">
    @csrf
    <dl>
      <dt>Family Code</dt>
      <dd>
        <input type="hidden" name="family_code" value="{{$check->family_code}}">
        {{$check->family_code}}
      </dd>
      <dt>Name</dt>
      <dd>
        <input type="hidden" name="name" value="{{$check->name}}">
        {{$check->name}}
      </dd>
      <dt>
        Password
      </dt>
      <dd>
        <input type="hidden" name="password" value="{{$check->password}}">
        [表示されません]
      </dd>
      @if($familycount)
        <div class="count">※{{$check->family_code}}は作成済みです。登録後は作成済みの{{$check->family_code}}に参加することになります。</div>
      @endif
    </dl>
    <div class="entry_submit">
      <a href="/index">編集する</a> ｜ <input id="input_buttom" type="submit" value="登録">
    </div>
  </form>
@endsection