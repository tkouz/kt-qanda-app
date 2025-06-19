<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

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

// 質問一覧表示のルート
Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');

// ★ここから追加★

// 質問詳細表示のルート
// /questions/{question} へのGETリクエストを QuestionController の show メソッドで処理する
// {question} はワイルドカードで、URLのこの部分が QuestionモデルのIDとして扱われる
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');

// ★ここまで追加★