<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    // テーブル名を指定
    protected $table = 'answers';

    // タイムスタンプカラムの自動管理を無効にする
    public $timestamps = false;

    // Mass Assignment（一括代入）で代入を許可するカラムを指定
    protected $fillable = [
        'question_id',
        'content',
        'image_path',
        'posted_at',
        'updated_at',
        'user_id',
        'is_visible',
    ];

    // questionに対するリレーション (一対多の逆)
    // 回答は一つの質問に属する
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // userに対するリレーション (一対多の逆)
    // 回答は一つのユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // commentsに対するリレーション (一対多)
    // 回答は複数のコメントを持つ
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // reportsに対するリレーション (ポリモーフィックリレーションの準備)
    // 回答は複数の報告を持つ可能性がある
    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }
}