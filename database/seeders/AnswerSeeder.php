<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Question;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DatabaseSeederでtruncateされているため、ここでは不要
        // DB::table('answers')->truncate();

        // ダミーデータ用のユーザーと質問を取得
        // UserSeederとQuestionSeederが先に実行されていることを前提とします。
        $user1 = User::where('email', 'test1@example.com')->first();
        $user2 = User::where('email', 'test2@example.com')->first();
        $adminUser = User::where('email', 'admin@example.com')->first();

        $question1 = Question::where('title', 'Laravelのマイグレーションについて教えてください')->first();
        $question2 = Question::where('title', 'Eloquent ORMのリレーションシップについて')->first();
        $question3 = Question::where('title', 'Webサイト開発の学習ロードマップ')->first();
        $question4 = Question::where('title', 'Docker Composeの基本的な使い方')->first();


        if (!$user1 || !$user2 || !$adminUser || !$question1 || !$question2 || !$question3 || !$question4) {
            $this->command->warn('必要なユーザーまたは質問データが見つかりません。UserSeederとQuestionSeederが先に実行されていることを確認してください。');
            return;
        }

        // 回答データの挿入
        DB::table('answers')->insert([
            [
                'question_id' => $question1->id, // 質問1への回答
                'content' => 'Laravelのマイグレーションは、データベースのスキーマをバージョン管理するための機能です。`php artisan make:migration` でファイルを作成し、`php artisan migrate` で実行します。カラムの追加・削除、テーブルの作成などが可能です。',
                'image_path' => null,
                'posted_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
                'user_id' => $user2->id, // testuser2が回答
                'is_visible' => true,
            ],
            [
                'question_id' => $question1->id, // 質問1への別の回答
                'content' => 'マイグレーションでは、`Schema::create` でテーブルを作成したり、`Schema::table` で既存テーブルを修正したりします。特に`up()`と`down()`メソッドを使って、適用とロールバックを記述できるのが便利です。',
                'image_path' => null,
                'posted_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
                'user_id' => $adminUser->id, // admin_userが回答
                'is_visible' => true,
            ],
            [
                'question_id' => $question2->id, // 質問2への回答
                'content' => 'Eloquentのリレーションシップは、データベースのテーブル間の関係をPHPオブジェクトとして扱えるようにする機能です。`hasMany`は一対多、`belongsTo`は多対一の関係を表します。ポリモーフィックリレーションは、一つのモデルが複数の他のモデルに属する場合に使われます。',
                'image_path' => null,
                'posted_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
                'user_id' => $user1->id, // testuser1が回答
                'is_visible' => true,
            ],
            [
                'question_id' => $question4->id, // 質問4への回答
                'content' => 'Docker Composeは、複数のDockerコンテナで構成されるアプリケーションを定義し、実行するためのツールです。`docker-compose.yml` ファイルでサービス、ネットワーク、ボリュームなどを定義し、`docker-compose up` でまとめて起動できます。開発環境の構築に非常に便利です。',
                'image_path' => null,
                'posted_at' => Carbon::now()->subHours(6),
                'updated_at' => Carbon::now()->subHours(6),
                'user_id' => $adminUser->id, // admin_userが回答
                'is_visible' => true,
            ],
        ]);
    }
}