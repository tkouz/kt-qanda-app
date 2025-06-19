<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // DBファサードを使用
use Carbon\Carbon; // 日付時刻の操作にCarbonライブラリを使用
use App\Models\User; // Userモデルを使用

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    

        // ダミーデータ用のユーザーIDを取得
        // UserSeederが先に実行されていることを前提とします。
        $user1 = User::where('email', 'test1@example.com')->first();
        $user2 = User::where('email', 'test2@example.com')->first();
        $adminUser = User::where('email', 'admin@example.com')->first();

        // ユーザーが存在しない場合はシーダーの実行を中断またはエラー表示
        if (!$user1 || !$user2 || !$adminUser) {
            $this->command->warn('ユーザーデータが見つかりません。UserSeederが先に実行されていることを確認してください。');
            return;
        }

        // 質問データの挿入
        DB::table('questions')->insert([
            [
                'title' => 'Laravelのマイグレーションについて教えてください',
                'content' => 'Laravelでデータベースのスキーマを管理するマイグレーション機能について詳しく知りたいです。具体的にどのようなコマンドがあり、どのようなことができるのでしょうか？',
                'image_path' => null,
                'posted_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
                'user_id' => $user1->id, // testuser1のID
                'is_visible' => true,
            ],
            [
                'title' => 'Eloquent ORMのリレーションシップについて',
                'content' => 'LaravelのEloquent ORMにおけるリレーションシップ（hasMany, belongsToなど）の具体的な使い方と、ポリモーフィックリレーションシップについて教えてください。',
                'image_path' => null,
                'posted_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
                'user_id' => $user2->id, // testuser2のID
                'is_visible' => true,
            ],
            [
                'title' => 'Webサイト開発の学習ロードマップ',
                'content' => 'Webサイト開発を学習する上で、初心者におすすめのロードマップや、次に学ぶべき技術についてアドバイスをください。',
                'image_path' => null, // 後で画像のパスを設定する練習にも使える
                'posted_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
                'user_id' => $adminUser->id, // admin_userのID
                'is_visible' => true,
            ],
            [
                'title' => 'Docker Composeの基本的な使い方',
                'content' => 'Docker Composeを使って複数のコンテナを連携させる方法や、よく使うコマンドについて知りたいです。特にLaravel開発での活用例があれば助かります。',
                'image_path' => null,
                'posted_at' => Carbon::now()->subHours(12),
                'updated_at' => Carbon::now()->subHours(12),
                'user_id' => $user1->id, // testuser1のID
                'is_visible' => true,
            ],
            [
                'title' => '（非表示テスト用）非表示にする質問',
                'content' => 'この質問はis_visibleがfalseになっているため、通常は表示されないはずです。',
                'image_path' => null,
                'posted_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
                'user_id' => $user2->id, // testuser2のID
                'is_visible' => false, // 非表示設定
            ],
        ]);
    }
}