<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // テーブル名を指定
    protected $table = 'comments';

    // タイムスタンプカラムの自動管理を無効にする
    // マイグレーションで posted_at と updated_at を定義済みですが、
    // ここで timestamps() を false にすることで、Laravelが自動で現在時刻をセットしないようにします。
    public $timestamps = false;

    // Mass Assignment（一括代入）で代入を許可するカラムを指定
    protected $fillable = [
        'answer_id',
        'content',
        'posted_at',
        'updated_at', // 要件定義で編集不可でも、データベースにはカラムが存在するため含めます
        'user_id',
    ];

    // answerに対するリレーション (一対多の逆)
    // コメントは一つの回答に属する
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    // userに対するリレーション (一対多の逆)
    // コメントは一つのユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}