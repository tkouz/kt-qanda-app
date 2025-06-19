<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Answer; // Answerモデルを使用

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DatabaseSeederでtruncateされているため、ここでは不要
        // DB::table('comments')->truncate();

        // ダミーデータ用のユーザーと回答を取得
        // UserSeederとAnswerSeederが先に実行されていることを前提とします。
        $user1 = User::where('email', 'test1@example.com')->first();
        $user2 = User::where('email', 'test2@example.com')->first();

        // AnswerSeederで作成した回答の中からいくつか取得
        // ここでは、contentの一部で検索して回答を特定します。
        $answer1 = Answer::where('content', 'LIKE', '%Laravelのマイグレーションは%')->first();
        $answer2 = Answer::where('content', 'LIKE', '%Eloquentのリレーションシップは%')->first();
        $answer3 = Answer::where('content', 'LIKE', '%Docker Composeは%')->first();


        if (!$user1 || !$user2 || !$answer1 || !$answer2 || !$answer3) {
            $this->command->warn('必要なユーザーまたは回答データが見つかりません。UserSeederとAnswerSeederが先に実行されていることを確認してください。');
            return;
        }

        // コメントデータの挿入
        DB::table('comments')->insert([
            [
                'answer_id' => $answer1->id, // 回答1へのコメント
                'content' => '非常に分かりやすい解説ありがとうございます！助かりました！',
                'posted_at' => Carbon::now()->subDays(3)->addHours(2), // 回答の少し後にコメント
                'updated_at' => Carbon::now()->subDays(3)->addHours(2),
                'user_id' => $user1->id, // testuser1がコメント
            ],
            [
                'answer_id' => $answer2->id, // 回答2へのコメント
                'content' => 'ポリモーフィックリレーションは奥が深いですね。具体的なコード例があると嬉しいです！',
                'posted_at' => Carbon::now()->subDays(1)->addHours(1),
                'updated_at' => Carbon::now()->subDays(1)->addHours(1),
                'user_id' => $user2->id, // testuser2がコメント
            ],
            [
                'answer_id' => $answer3->id, // 回答3へのコメント
                'content' => 'Docker Compose、私も開発で活用しています！ローカル環境構築が劇的に楽になりますよね。',
                'posted_at' => Carbon::now()->subHours(3),
                'updated_at' => Carbon::now()->subHours(3),
                'user_id' => $user1->id, // testuser1がコメント
            ],
        ]);
    }
}