<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Answer;
use Carbon\Carbon;

class Question extends Model
{
    use HasFactory;

    // ★この行を追加★ 一括代入を許可するカラム
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'posted_at',
        'is_visible',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
    ];

    // ... (既存のリレーションシップメソッドはそのまま)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}