<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // テーブル名を指定
    protected $table = 'reports';

    // Laravelのタイムスタンプカラム (created_at, updated_at) を使用しない設定
    // 今回は posted_at しかないため
    public $timestamps = false;

    // Mass Assignment（一括代入）で代入を許可するカラムを指定
    protected $fillable = [
        'reported_object_type',
        'reported_object_id',
        'reporter_user_id',
        'report_reason',
        'report_comment',
        'posted_at',
        'is_handled',
    ];

    // 報告者ユーザーに対するリレーション (一対多の逆)
    // 報告は一人のユーザーによって行われる
    public function reporterUser()
    {
        return $this->belongsTo(User::class, 'reporter_user_id'); // foreign key を明示
    }

    // 報告対象に対するリレーション (ポリモーフィックリレーション)
    // reported_object_type と reported_object_id を使って、
    // 質問(Question) または 回答(Answer) のどちらかを参照する
    public function reportable()
    {
        return $this->morphTo();
    }
}