<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    // テーブル名を指定
    protected $table = 'bookmarks';

    // 自動増分IDが無いため、primaryKeyを無効化
    public $incrementing = false;

    // 主キーの型がINTなのでstringではなくintに設定（Laravel 7以降のEloquentで複合主キーを扱う場合、型を合わせる）
    protected $keyType = 'int';

    // Laravelのタイムスタンプカラム (created_at, updated_at) を使用しない設定
    // マイグレーションで 'posted_at' は定義しましたが、'updated_at' はないため、false に設定します。
    // 'posted_at' は手動で管理するか、リレーションシップで withTimestamps() を使用します。
    public $timestamps = false;

    // 複合主キーのカラム名を指定
    // このプロパティは、Laravelが複合主キーを正しく扱うために重要です。
    protected $primaryKey = ['user_id', 'question_id'];

    // Mass Assignment（一括代入）で代入を許可するカラムを指定
    protected $fillable = [
        'user_id',
        'question_id',
        'posted_at',
    ];

    // userに対するリレーション (一対多の逆)
    // ブックマークは一つのユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // questionに対するリレーション (一対多の逆)
    // ブックマークは一つの質問に属する
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}