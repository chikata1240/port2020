<?php

use App\Http\Controllers\KakeiboController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('first.login');
});

Route::post('/', 'KakeiboController@login');

Route::get('/index', function () {
    return view('second.index');
});

Route::post('/index', 'KakeiboController@index');

Route::post('/thanks', 'KakeiboController@thanks');

Route::get('/input/{day}', 'KakeiboController@input');

Route::post('/input', 'KakeiboController@inputadd');

Route::get('/detail/{ym}', 'KakeiboController@detail');

Route::get('/delete/{id}', 'KakeiboController@delete');

Route::get('/calendar', 'KakeiboController@calendar');

Route::get('/{ym}', 'KakeiboController@calendarappdown');
