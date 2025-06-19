<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController; // ★この行を追加★

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
    return view('welcome');
});

// ★ここから追加★

// 質問一覧表示のルート
// /questions へのGETリクエストを QuestionController の index メソッドで処理する
Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');

// ★ここまで追加★