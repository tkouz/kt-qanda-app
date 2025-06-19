<?php

namespace App\Enums;

enum ReportedObjectType: string
{
    case Question = 'question';
    case Answer = 'answer';

    // 必要に応じて、表示名などを取得するメソッドを追加
    public function label(): string
    {
        return match($this) {
            self::Question => '質問',
            self::Answer => '回答',
        };
    }
}