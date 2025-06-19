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

// ★ここが重要★
// 質問投稿フォーム表示のルート (より具体的なので先に定義)
Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');

// 質問詳細表示のルート (ワイルドカードを含むので後に定義)
Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('questions.show');

// 質問を保存するルート
// /questions へのPOSTリクエストを QuestionController の store メソッドで処理する
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

// sanctumやstorageなどの他のルートも元に戻す
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show'])
    ->middleware('web')
    ->name('sanctum.csrf-cookie');

use Illuminate\Support\Facades\Storage;
Route::get('storage/{path}', function ($path) {
    return Storage::response($path);
})->where('path', '.*')->name('storage.local');

Route::get('/up', function () {
    return response('ok');
});