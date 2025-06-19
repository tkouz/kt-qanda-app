<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // 必要に応じてコメント解除
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; 

// ★ Laravel 9以降でEnumキャストを使用する場合
use App\Enums\UserRole; // 後でこのEnumクラスを作成（現時点ではまだ存在しない）

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username', // 'name' から 'username' に変更
        'email',
        'password',
        // 追加したカラムを全て追記
        'profile_image',
        'self_introduction',
        'last_login_at',
        'registered_at',
        'role',
        'is_active',
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
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        // 追加したタイムスタンプ系カラムのキャスト
        'last_login_at' => 'datetime',
        'registered_at' => 'datetime',
        // Enumカラムのキャスト (後でEnumクラス作成)
        'role' => UserRole::class, // ★ ここでUserRole::classを指定
        // booleanカラムのキャスト
        'is_active' => 'boolean',
    ];
}