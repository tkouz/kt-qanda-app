<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // DBファサードを使用
use Illuminate\Support\Facades\Hash; // パスワードのハッシュ化に使用
use Carbon\Carbon; // 日付時刻の操作にCarbonライブラリを使用

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    

        // ユーザーデータの挿入
        DB::table('users')->insert([
            [
                'username' => 'testuser1',
                'email' => 'test1@example.com',
                'password_hash' => Hash::make('password123'), // パスワードをハッシュ化
                'profile_image' => null, // null許容
                'self_introduction' => 'こんにちは、テストユーザー1です。', // null許容
                'last_login_at' => Carbon::now(),
                'registered_at' => Carbon::now()->subDays(10), // 10日前に登録
                'updated_at' => Carbon::now(),
                'role' => 'general', // 一般ユーザー
                'is_active' => true,
                'password_reset_token' => null,
                'password_reset_expires_at' => null,
            ],
            [
                'username' => 'testuser2',
                'email' => 'test2@example.com',
                'password_hash' => Hash::make('password123'),
                'profile_image' => null,
                'self_introduction' => 'こんにちは、テストユーザー2です。Q&Aサイトを楽しんでいます。',
                'last_login_at' => Carbon::now()->subDays(1),
                'registered_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(1),
                'role' => 'general',
                'is_active' => true,
                'password_reset_token' => null,
                'password_reset_expires_at' => null,
            ],
            [
                'username' => 'admin_user',
                'email' => 'admin@example.com',
                'password_hash' => Hash::make('adminpassword'), // 管理者用のパスワード
                'profile_image' => null,
                'self_introduction' => '私は管理者です。サイトの管理を担当します。',
                'last_login_at' => Carbon::now(),
                'registered_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now(),
                'role' => 'admin', // 管理者
                'is_active' => true,
                'password_reset_token' => null,
                'password_reset_expires_at' => null,
            ],
        ]);
    }
}