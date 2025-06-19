<?php

namespace App\Enums;

enum UserRole: string
{
    case General = 'general';
    case Admin = 'admin';

    // 必要に応じて、表示名などを取得するメソッドを追加
    public function label(): string
    {
        return match($this) {
            self::General => '一般ユーザー',
            self::Admin => '管理者',
        };
    }
}