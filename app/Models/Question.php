<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // ★この行がまだなければ追加★
use Carbon\Carbon; // ★この行を追加★ (厳密には不要ですが、Carbonを使う意図を明確に)


class Question extends Model
{
    use HasFactory;

    // posted_at カラムをCarbonインスタンスとして扱うための設定
    protected $casts = [
        'posted_at' => 'datetime', // ★この行を追加★
    ];

    /**
     * 質問に紐づくユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}