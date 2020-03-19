@extends('layouts.index')

@section('title','会員登録')

@section('form')
  <form action="/index" method="post">
    @csrf
    <dl>
      <dt>
        Family Code
        @error ('family_code')
          <span class="error">{{$message}}</span>
        @enderror
      </dt>
      <dd>
        <input type="text" name="family_code" value="{{old('family_code')}}">
      </dd>
      <dt>
        Name
        @error('name')
          <span class="error">{{$message}}</span>
        @enderror
      </dt>
      <dd>
        <input type="text" name="name" value="{{old('name')}}">
      </dd>
      <dt>
        Password
        <br>
        <span>※４文字以上でご登録ください</span>
        @error('password')
          <span class="error">{{$message}}</span>
        @enderror
      </dt>
      <dd>
        <input type="password" name="password" value="">
      </dd>
    </dl>
    <div class="entry_submit">
      <input id="submit_buttom" type="submit" value="登録">
    </div>
  </form>
@endsection