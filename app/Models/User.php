<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // 必要に応じてコメント解除
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Question; // ★この行を追加★
use App\Models\Answer;   // ★この行を追加★
use App\Models\Comment;  // ★この行を追加★
use App\Models\Report;   // ★この行を追加★ (ポリモーフィックではないReportable_idを持つreportsへのリレーションは不要)
use App\Models\Bookmark; // ★この行を追加★

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'registered_at' => 'datetime', // ★この行を追加★
    ];

    /**
     * ユーザーが投稿した質問を複数取得 (hasMany)
     */
    public function questions() // ★このメソッドを追加★
    {
        return $this->hasMany(Question::class);
    }

    /**
     * ユーザーが投稿した回答を複数取得 (hasMany)
     */
    public function answers() // ★このメソッドを追加★
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * ユーザーが投稿したコメントを複数取得 (hasMany)
     */
    public function comments() // ★このメソッドを追加★
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * ユーザーが報告したレポートを複数取得 (hasMany)
     * (reported_object_type, reported_object_id へのリレーションではなく、reporter_user_id へのリレーション)
     */
    public function reports() // ★このメソッドを追加★
    {
        return $this->hasMany(Report::class, 'reporter_user_id');
    }

    /**
     * ユーザーがブックマークした質問を複数取得 (belongsToMany)
     */
    public function bookmarks() // ★このメソッドを追加★
    {
        // bookmarksテーブルは中間テーブル
        return $this->belongsToMany(Question::class, 'bookmarks', 'user_id', 'question_id')
                    ->withPivot('posted_at') // 中間テーブルの posted_at カラムも取得
                    ->as('bookmark') // リレーション名を 'bookmark' とエイリアス設定 (任意)
                    ->withTimestamps(false); // bookmarksテーブルにはcreated_at, updated_atがないためfalse
    }
}