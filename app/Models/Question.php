<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Answer; // ★この行を追加★
use Carbon\Carbon;

class Question extends Model
{
    use HasFactory;

    protected $casts = [
        'posted_at' => 'datetime',
    ];

    /**
     * 質問に紐づくユーザーを取得 (belongsTo: 一つの質問は一つのユーザーに属する)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 質問に紐づく回答を複数取得 (hasMany: 一つの質問は複数の回答を持つ)
     */
    public function answers() // ★このメソッドを追加★
    {
        return $this->hasMany(Answer::class);
    }
}