<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    // テーブル名を指定（モデル名が複数形にならない場合や、Laravelの命名規則と異なる場合）
    // 今回は 'questions' なので、実は指定は不要ですが、明示的に記述するのも良いプラクティスです。
    protected $table = 'questions';

    // タイムスタンプカラムの自動管理を無効にする（posted_atとupdated_atを自分で管理するため）
    // 'posted_at' と 'updated_at' を手動で管理するため、Laravelの timestamps() を無効化します。
    public $timestamps = false;

    // Mass Assignment（一括代入）で代入を許可するカラムを指定
    // ここに指定したカラムは、create() や update() メソッドで一括して値を設定できるようになります。
    protected $fillable = [
        'title',
        'content',
        'image_path',
        'posted_at',
        'updated_at',
        'user_id',
        'is_visible',
    ];

    // userに対するリレーション (一対多の逆)
    // 質問は一つのユーザーに属する
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // answersに対するリレーション (一対多)
    // 質問は複数の回答を持つ
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // reportsに対するリレーション (ポリモーフィックリレーションの準備)
    // 質問は複数の報告を持つ可能性がある
    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    // bookmarksに対するリレーション (多対多)
    // 質問は複数のユーザーによってブックマークされる
    public function usersWhoBookmarked()
    {
        return $this->belongsToMany(User::class, 'bookmarks', 'question_id', 'user_id')
                    ->withTimestamps('posted_at', null); // ブックマークテーブルのタイムスタンプカラムを指定
    }
}