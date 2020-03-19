<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/input/detail/smart_detail_styles.css')}}">
  <link rel="stylesheet" href="{{asset('css/input/detail/tablet_detail_styles.css')}}">
  <link rel="stylesheet" href="{{asset('css/input/detail/pc_detail_styles.css')}}">
  <title>input</title>
</head>
<body>
  <header>
    <a href="/calendar">
      <div>
        <p>ホーム</p>
      </div>
    </a>
  </header>

  <div class="detail_box">
    <div class="detail_title">
      {{$ymdetail}}
    </div>
    <div class="detail_body">
      @foreach ($details as $detail)
      <div class="detail_boy_box">
        <div class="detail_boy">
          <p>{{$detail->member->name}}</p>
          <a href="/delete/{{$detail->id}}">
            <div>
              削除
            </div>
          </a>
        </div>
        <div class="detail_memo_box">
          <p>{{$detail->budget}}</p>
          <p>{{$detail->money}}</p>
        </div>
        <p>{{$detail->memo}}</p>
      </div>
      @endforeach
    </div>

    <div class="detail_sum_box">
      <p>支出 ¥</p>
      @if (isset($sumexpense))
        <p>{{$sumexpense}}</p>
      @else
        <p>0</p>
      @endif
      <p>収入 ¥</p>
      @if (isset($sumincome))
        <p>{{$sumincome}}</p>
      @else
        <p>0</p>
      @endif
    </div>
  </div>

  <!-- footer -->
  <footer>
    <a href="/input/{{$ymdetail}}">
      <div>
        <p>きろくする</p>
      </div>
    </a>
  </footer>
</body>
</html>