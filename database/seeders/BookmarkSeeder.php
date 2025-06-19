<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Question;

class BookmarkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DatabaseSeederでtruncateされているため、ここでは不要
        // DB::table('bookmarks')->truncate();

        // ダミーデータ用のユーザーと質問を取得
        $user1 = User::where('email', 'test1@example.com')->first();
        $user2 = User::where('email', 'test2@example.com')->first();
        $adminUser = User::where('email', 'admin@example.com')->first();

        $question1 = Question::where('title', 'Laravelのマイグレーションについて教えてください')->first();
        $question2 = Question::where('title', 'Eloquent ORMのリレーションシップについて')->first();
        $question3 = Question::where('title', 'Webサイト開発の学習ロードマップ')->first();
        $question4 = Question::where('title', 'Docker Composeの基本的な使い方')->first();


        if (!$user1 || !$user2 || !$adminUser || !$question1 || !$question2 || !$question3 || !$question4) {
            $this->command->warn('必要なユーザーまたは質問データが見つかりません。関連するSeederが先に実行されていることを確認してください。');
            return;
        }

        // ブックマークデータの挿入
        DB::table('bookmarks')->insert([
            // testuser1が質問1をブックマーク
            [
                'user_id' => $user1->id,
                'question_id' => $question1->id,
                'posted_at' => Carbon::now()->subDays(2),
            ],
            // testuser1が質問2をブックマーク
            [
                'user_id' => $user1->id,
                'question_id' => $question2->id,
                'posted_at' => Carbon::now()->subDays(1),
            ],
            // testuser2が質問1をブックマーク
            [
                'user_id' => $user2->id,
                'question_id' => $question1->id,
                'posted_at' => Carbon::now()->subHours(10),
            ],
            // admin_userが質問4をブックマーク
            [
                'user_id' => $adminUser->id,
                'question_id' => $question4->id,
                'posted_at' => Carbon::now()->subHours(5),
            ],
        ]);
    }
}