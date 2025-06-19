<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 外部キー制約を一時的に無効化
        Schema::disableForeignKeyConstraints();

        // 既存のデータをクリア（依存関係の逆順に）
        // answersはuser, questionに依存
        // commentsはanswerに依存
        // reportsはuser, question, answerに依存
        // bookmarksはuser, questionに依存
        DB::table('comments')->truncate(); // comments -> answers -> questions, users
        DB::table('answers')->truncate();
        DB::table('reports')->truncate();
        DB::table('bookmarks')->truncate();
        DB::table('questions')->truncate();
        DB::table('users')->truncate();

        // シーダーを実行（依存関係の順に）
        $this->call([
            UserSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,    // ここから追加
            CommentSeeder::class,   // ここから追加
            ReportSeeder::class,    // ここから追加
            BookmarkSeeder::class,  // ここから追加
        ]);

        // 外部キー制約を再度有効化
        Schema::enableForeignKeyConstraints();
    }
}