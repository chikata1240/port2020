<?php

namespace App\Http\Controllers;

use Session;
use Validator;
use App\Http\Requests\KakeiboRequest;
use App\Http\Requests\InputRequest;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use App\Member;
use App\Book;

class KakeiboController extends Controller
{

    public function index(KakeiboRequest $request)
    {
        // fimily_code,name,passwordの登録情報確認
        $index = Member::where('family_code', $request->family_code)->where('name', $request->name)->where('password', $request->password)->doesntExist();
        // family_codeの存在確認
        $familycount = Member::where('family_code', $request->family_code)->count();

        $check = $request;
        if ($index) {
            return view('second.check', compact('check', 'familycount'));
        } else {
            return view('second.index');
        }
    }

    public function thanks(Request $request)
    {
        $members = new Member();
        $members->create([
            'name' => $request->name,
            'family_code' => $request->family_code,
            'password' => sha1($request->password),
        ]);

        return view('second.thanks');
    }

    public function login(Request $request)
    {
        $login = Member::where('name', $request->name)->where('password', sha1($request->password))->first();
        // name,pass合っていればログイン
        if (isset($login)) {
            // session　の保存
            $request->session()->put('family_code', $login->family_code);
            $request->session()->put('name', $login->name);
            $request->session()->put('id', $login->id);
            $today = new Carbon('today');
            // 〇〇年〇〇月で表示
            $todayDay = $today->format('Y年m月');
            // アクセス時の年月の１日を変数に代入
            $tempDate = Carbon::createFromDate($today->year, $today->month, 1);
            // カレンダー左上のズレを代入
            $skip = $tempDate->dayOfWeek;
            // $tempDateにカレンダー左上のズレの日数分マイナスする
            for ($i = 0; $i < $skip; $i++) {
                $tempDate->subDay();
            }
            // カレンダーの日付変更
            $prevnum = Carbon::createFromDate($today->year, $today->month - 1);
            $nextnum = Carbon::createFromDate($today->year, $today->month + 1);
            $prev = $prevnum->format('Y-m');
            $next = $nextnum->format('Y-m');

            // その月の合計金額
            // 月(carbon)　＋　family_code(member) + sum
            $ymtemp = substr($tempDate, 0, 7);
            $monthsum = Book::whereHas('member', function ($query) use ($login) {
                $query->where('family_code', $login->family_code);
            })->where('budget', '支出')->where('days', 'LIKE', $ymtemp . '%')->sum('money');
            // その月の支出人物の特定
            $testers = Member::where('family_code', session('family_code'))->pluck('id');
            foreach ($testers as $tester) {
                $monthpersonsum[] = Book::whereHas('member', function ($query) {
                    $query->where('family_code', session('family_code'));
                })->where('family_number', $tester)->where('budget', '支出')->where('days', 'LIKE', $ymtemp . '%')->sum('money');
                // 名前の取得
                $monthperson[] = Member::where('id', $tester)->where('family_code', session('family_code'))->get();
            }
            // echo $login;
            return view('calendar.calendar', compact('todayDay', 'today', 'tempDate', 'prev', 'next', 'monthsum', 'monthpersonsum', 'monthperson'));
        } else {
            return redirect('/login');
        }
    }

    public function input($day)
    {
        if (Session::has('family_code')) {
            // 取得日付を整形、セッションに保存
            $day = substr($day, 0, 10);
            session(['day' => $day]);

            return view('first.input');
        } else {
            return redirect('/login');
        }
    }

    public function inputadd(InputRequest $request)
    {
        if (Session::has('family_code')) {
            $members = Book::create([
                'family_number' => session('id'),
                'budget' => $request->budget,
                'money' => $request->money,
                'memo' => $request->memo,
                'days' => session('day'),
            ]);

            return view('first.input');
        } else {
            return redirect('/login');
        }
    }

    public function detail($ym)
    {
        if (Session::has('family_code')) {
            // 取得日付format
            $ymdetail = substr($ym, 0, 10);
            Session::put('detailym', $ymdetail);

            // 取得日付の情報を取得
            $details = Book::with(['member:id,name'])->whereHas('member', function ($query) {
                $query->where('family_code', session('family_code'));
            })->nameEqual($ymdetail)->get();

            // 収支の合計金額取得
            $sumincome = Book::whereHas('member', function ($query) {
                $query->where('family_code', session('family_code'));
            })->where('budget', '収入')->where('days', $ymdetail)->sum('money');
            $sumexpense = Book::whereHas('member', function ($query) {
                $query->where('family_code', session('family_code'));
            })->where('budget', '支出')->where('days', $ymdetail)->sum('money');

            return view('first.detail', compact('details', 'sumincome', 'sumexpense', 'ymdetail'));
        } else {
            return redirect('/login');
        }
    }

    public function delete($id)
    {
        if (Session::has('family_code')) {
            Book::destroy($id);

            $ymdetail = session('detailym');

            // 取得日付の情報を取得
            $details = Book::with(['member:id,name'])->whereHas('member', function ($query) {
                $query->where('family_code', session('family_code'));
            })->nameEqual($ymdetail)->get();

            // 収支の合計金額取得
            $sumincome = Book::whereHas('member', function ($query) {
                $query->where('family_code', session('family_code'));
            })->where('budget', '収入')->where('days', $ymdetail)->sum('money');
            $sumexpense = Book::whereHas('member', function ($query) {
                $query->where('family_code', session('family_code'));
            })->where('budget', '支出')->where('days', $ymdetail)->sum('money');

            return view('first.detail', compact('details', 'sumincome', 'sumexpense', 'ymdetail'));
        } else {
            return redirect('/login');
        }
    }

    public function calendar(Request $request)
    {
        if ($request->session()->exists('family_code')) {
            $login = Member::where('name', session('name'))->where('family_code', session('family_code'))->first();

            $today = new Carbon('today');
            // 〇〇年〇〇月で表示
            $todayDay = $today->format('Y年m月');
            // アクセス時の年月の１日を変数に代入
            $tempDate = Carbon::createFromDate($today->year, $today->month, 1);

            // カレンダー左上のズレを代入
            $skip = $tempDate->dayOfWeek;
            // $tempDateにカレンダー左上のズレの日数分マイナスする
            for ($i = 0; $i < $skip; $i++) {
                $tempDate->subDay();
            }
            // 前の月、次の月
            $prevnum = Carbon::createFromDate($today->year, $today->month - 1);
            $nextnum = Carbon::createFromDate($today->year, $today->month + 1);
            $prev = $prevnum->format('Y-m');
            $next = $nextnum->format('Y-m');

            // その月の合計金額
            // 月(carbon)　＋　family_code(member) + sum
            $ymtemp = substr($tempDate, 0, 7);
            $monthsum = Book::whereHas('member', function ($query) use ($login) {
                $query->where('family_code', $login->family_code);
            })->where('budget', '支出')->where('days', 'LIKE', $ymtemp . '%')->sum('money');
            // その月の支出人物の特定
            $testers = Member::where('family_code', session('family_code'))->pluck('id');
            foreach ($testers as $tester) {
                $monthpersonsum[] = Book::whereHas('member', function ($query) {
                    $query->where('family_code', session('family_code'));
                })->where('family_number', $tester)->where('budget', '支出')->where('days', 'LIKE', $ymtemp . '%')->sum('money');
                // 名前の取得
                $monthperson[] = Member::where('id', $tester)->where('family_code', session('family_code'))->get();
            }

            return view('calendar.calendar', compact('todayDay', 'today', 'tempDate', 'prev', 'next', 'monthsum', 'monthpersonsum', 'monthperson'));
        } else {
            return redirect('/login');
        }
    }

    public function calendarappdown($ym)
    {
        if (Session::has('family_code')) {
            // カレンダー情報の取得
            $today = new Carbon($ym);
            // 〇〇年〇〇月で表示
            $todayDay = $today->format('Y年m月');
            // アクセス時の年月の１日を変数に代入
            $tempDate = Carbon::createFromDate($today->year, $today->month, 1);
            // カレンダー左上のズレを代入
            $skip = $tempDate->dayOfWeek;
            // $tempDateにカレンダー左上のズレの日数分マイナスする
            for ($i = 0; $i < $skip; $i++) {
                $tempDate->subDay();
            }
            // 前の月、次の月
            $prevnum = Carbon::createFromDate($today->year, $today->month - 1);
            $nextnum = Carbon::createFromDate($today->year, $today->month + 1);
            $prev = $prevnum->format('Y-m');
            $next = $nextnum->format('Y-m');

            // その月の合計金額
            // 月(carbon)　＋　family_code(member) + sum
            $monthsum = Book::whereHas('member', function ($query) {
                $query->where('family_code', session('family_code'));
            })->where('budget', '支出')->where('days', 'LIKE', $ym . '%')->sum('money');

            // その月の支出人物の特定
            $testers = Member::where('family_code', session('family_code'))->pluck('id');
            foreach ($testers as $tester) {
                $monthpersonsum[] = Book::whereHas('member', function ($query) {
                    $query->where('family_code', session('family_code'));
                })->where('family_number', $tester)->where('budget', '支出')->where('days', 'LIKE', $ym . '%')->sum('money');
                // 名前の取得
                $monthperson[] = Member::where('id', $tester)->where('family_code', session('family_code'))->get();
            }
            return view('calendar.calendar', compact('todayDay', 'today', 'tempDate', 'prev', 'next', 'monthsum', 'monthpersonsum', 'monthperson'));
        } else {
            return redirect('/login');
        }
    }
}
