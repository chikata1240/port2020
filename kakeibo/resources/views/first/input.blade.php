<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/input/input/smart_input_styles.css')}}">
  <link rel="stylesheet" href="{{asset('css/input/input/tablet_input_styles.css')}}">
  <link rel="stylesheet" href="{{asset('css/input/input/pc_input_styles.css')}}">
  <title>input</title>
</head>
<body>
  <header>
    <div>
      <p class="input_title">きろく</p>
    </div>
  </header>

  <div class="input_box">
    <div class="input_title">
      <p>{{session('day')}}</p>
    </div>

    <form action="/input" method="POST">
      @csrf
      <div class="budget">
        <input id="income" class="radio-inline__input" type="radio" name="budget" value="支出" checked="checked" />
        <label class="radio-inline__label" for="income">
          支出
        </label>
        <input id="expenditure" class="radio-inline__input" type="radio" name="budget" value="収入" />
        <label class="radio-inline__label" for="expenditure">
          収入
        </label>
      </div>
      <br>
      <div class="money_text">
        <input id="money" type="text" name="money" placeholder="0">
      </div>
      <br>
      @error('memo')
        <p class="error">{{$message}}</p>
      @enderror
      <div class="memo_textarea">
        <textarea id="memo" name="memo" wrap="soft" placeholder="例）食費"></textarea>
      </div>
      <br>
      <div class="submit_box">
        <input id="submit" type="submit" value="送信">
      </div>
    </form>
  </div>

  <!-- footer -->
  <footer>
    <a href="/calendar">
      <div>
        <p>ホーム</p>
      </div>
    </a>
  </footer>
</body>
</html>