<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User; // Userモデルも使用するので念のため確認
use App\Models\Answer; // Answerモデルも使用するので追加
use App\Models\Comment; // Commentモデルも使用するので追加
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * 質問一覧を表示する
     */
    public function index()
    {
        $questions = Question::where('is_visible', true)
                            ->orderBy('posted_at', 'desc')
                            ->paginate(10);

        return view('questions.index', compact('questions'));
    }

    /**
     * 質問詳細を表示する
     */
    public function show(Question $question) // ★このメソッドを追加★
    {
        // ルートモデルバインディングにより、既に$questionは該当する質問オブジェクトになっている
        // 回答とそれに紐づくコメント、投稿ユーザーをEager Load（事前読み込み）する
        // posted_atがtrueの回答のみ、posted_atで並び替え
        $question->load([
            'answers' => function ($query) {
                $query->where('is_visible', true)->orderBy('posted_at', 'asc');
            },
            'answers.user', // 各回答の投稿ユーザーも読み込む
            'answers.comments' => function ($query) {
                $query->orderBy('posted_at', 'asc');
            },
            'answers.comments.user', // 各コメントの投稿ユーザーも読み込む
            'user' // 質問自体の投稿ユーザーも読み込む
        ]);

        return view('questions.show', compact('question'));
    }
}