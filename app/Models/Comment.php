<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer; // ★この行を追加★
use App\Models\User;   // ★この行を追加★
use Carbon\Carbon;

class Comment extends Model
{
    use HasFactory;

    protected $casts = [
        'posted_at' => 'datetime', // ★この行を追加★
    ];

    /**
     * コメントが属する回答を取得 (belongsTo: 一つのコメントは一つの回答に属する)
     */
    public function answer() // ★このメソッドを追加★
    {
        return $this->belongsTo(Answer::class);
    }

    /**
     * コメントに紐づくユーザーを取得 (belongsTo: 一つのコメントは一つのユーザーに属する)
     */
    public function user() // ★このメソッドを追加★
    {
        return $this->belongsTo(User::class);
    }
}