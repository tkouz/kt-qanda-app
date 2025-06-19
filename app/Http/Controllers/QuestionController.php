<?php

namespace App\Http\Controllers;

use App\Models\Question; // ★この行を追加★ Questionモデルを使うため
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * 質問一覧を表示する
     */
    public function index()
    {
        // is_visible が true の質問のみを取得し、posted_at の新しい順に並べ替えてページネーション
        $questions = Question::where('is_visible', true)
                            ->orderBy('posted_at', 'desc')
                            ->paginate(10); // 1ページあたり10件表示

        // 取得した質問データをビューに渡して表示
        return view('questions.index', compact('questions'));
    }
}