<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use App\Models\Answer;
use App\Models\Comment;
use Illuminate\Http\Request; // ★この行がまだなければ追加されているか確認★
use Illuminate\Support\Facades\Auth; // ★この行を追加★ ログインユーザーのIDを取得するため

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
    public function show(Question $question)
    {
        $question->load([
            'answers' => function ($query) {
                $query->where('is_visible', true)->orderBy('posted_at', 'asc');
            },
            'answers.user',
            'answers.comments' => function ($query) {
                $query->orderBy('posted_at', 'asc');
            },
            'answers.comments.user',
            'user'
        ]);

        return view('questions.show', compact('question'));
    }

    /**
     * 新しい質問投稿フォームを表示する
     */
    public function create() // ★このメソッドを追加★
    {
        // ログインしていない場合はログインページにリダイレクトするなど、
        // 認証ミドルウェアで制御することも多いが、今回は簡略化
        return view('questions.create');
    }

    /**
     * 投稿された質問をデータベースに保存する
     */
    public function store(Request $request) // ★このメソッドを追加★
    {
        // 1. バリデーション
        // 後で詳細なバリデーションルールを追加します
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // 2. 質問の保存
        $question = new Question();
        $question->title = $request->title;
        $question->content = $request->content;
        $question->user_id = 1; // ★★★一時的に固定のユーザーIDを設定★★★
        $question->is_visible = true; // デフォルトで表示状態にする
        $question->save();

        // 3. 質問詳細ページにリダイレクト
        return redirect()->route('questions.show', $question->id)
                         ->with('success', '質問が投稿されました！'); // 成功メッセージをセッションに保存
    }
}