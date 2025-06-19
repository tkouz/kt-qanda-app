<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question; // ★この行を追加★
use App\Models\User;     // ★この行を追加★
use App\Models\Comment;  // ★この行を追加★
use Carbon\Carbon;

class Answer extends Model
{
    use HasFactory;

    protected $casts = [
        'posted_at' => 'datetime', // ★この行を追加★
    ];

    /**
     * 回答が属する質問を取得 (belongsTo: 一つの回答は一つの質問に属する)
     */
    public function question() // ★このメソッドを追加★
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * 回答に紐づくユーザーを取得 (belongsTo: 一つの回答は一つのユーザーに属する)
     */
    public function user() // ★このメソッドを追加★
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 回答に紐づくコメントを複数取得 (hasMany: 一つの回答は複数のコメントを持つ)
     */
    public function comments() // ★このメソッドを追加★
    {
        return $this->hasMany(Comment::class);
    }
}