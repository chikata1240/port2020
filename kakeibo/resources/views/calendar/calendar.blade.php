<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{asset('css/calendar/smart_calendar.css')}}">
  <link rel="stylesheet" href="{{asset('css/calendar/tablet_calendar.css')}}">
  <link rel="stylesheet" href="{{asset('css/calendar/pc_calendar.css')}}">
  <title>カレンダー</title>
</head>
<body>
  <!-- header -->
  <header>
    <div>
      <p class="calendar_title">ぽけいぼ</p>
    </div>
  </header>

  <!-- family name -->
  <div class="family_name">
    <img src="{{asset('image/kbou.png')}}" class="image_icon" alt="キャラクターのアイコンです">
    <p>近田家</p>
  </div>
  
  <!-- calendar -->
  <div class="calendar">
    <p class="title"><a href="{{$prev}}">&lt;</a>{{$todayDay}}<a href="{{$next}}">&gt;</a></p>
    <table class="table">
      <thead>
        <tr>
          <th>Sun</th>
          <th>Mon</th>
          <th>Tue</th>
          <th>Wed</th>
          <th>Thu</th>
          <th>Fri</th>
          <th>Sat</th>
        </tr>
      </thead>
      <tbody>
        <?php
          do {
            echo '<tr>';
              for ($i = 0; $i < 7; $i++) {
                if ($tempDate->month == $today->month) {
                  if ($tempDate->isToday()) {
                    echo "<td><a href='/detail/$tempDate'><div class='today'>" . $tempDate->day . "</div></a></td>";
                  }else
                    echo "<td><a href='/detail/$tempDate'><div>" . $tempDate->day . "</div></a></td>";
                }else{
                  echo '<td><div>' . ' ' . '</div></td>';
                }
                  $tempDate->addDay();
              }
                echo '</tr>';
          } while ($tempDate->month == $today->month);
        ?>
      </tbody>
    </table>
  </div>

  <!-- this month -->
  <div class="this_month">
    
    <div class="expenditure">
      @if (isset($monthsum))
        今月の出費： ¥ {{$monthsum}} -
      @else
      今月の出費： ¥ 0 -
      @endif
    </div>
    
    @if ($monthsum != 0)
      @for ($i = 0; $i < count($monthperson); $i++) 
        @foreach ($monthperson[$i] as $person)
          <div class="expenditure_name">
            {{$person->name}}： ¥
            {{$monthpersonsum[$i]}}
            -
          </div>
        @endforeach
      @endfor
    @endif
  </div>

  <!-- footer -->
  <footer>
    <a href="/input/{{$today}}">
      <div>
        <p>今日のきろく</p>
      </div>
    </a>
  </footer>
</body>
</html>