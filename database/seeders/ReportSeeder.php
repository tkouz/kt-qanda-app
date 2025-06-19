<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DatabaseSeederでtruncateされているため、ここでは不要
        // DB::table('reports')->truncate();

        // ダミーデータ用のユーザー、質問、回答を取得
        $user1 = User::where('email', 'test1@example.com')->first();
        $user2 = User::where('email', 'test2@example.com')->first();
        $adminUser = User::where('email', 'admin@example.com')->first();

        $questionToReport = Question::where('title', 'Webサイト開発の学習ロードマップ')->first();
        $answerToReport = Answer::where('content', 'LIKE', '%Docker Composeは%')->first(); // Docker Composeの回答

        if (!$user1 || !$user2 || !$adminUser || !$questionToReport || !$answerToReport) {
            $this->command->warn('必要なユーザー、質問、または回答データが見つかりません。関連するSeederが先に実行されていることを確認してください。');
            return;
        }

        // 報告データの挿入
        DB::table('reports')->insert([
            // 質問に対する報告
            [
                'reported_object_type' => 'App\\Models\\Question', // 報告対象のモデルのフルパス
                'reported_object_id' => $questionToReport->id, // 報告対象のID
                'reporter_user_id' => $user2->id, // 報告したユーザー (testuser2)
                'report_reason' => '不適切な内容',
                'report_comment' => 'この質問は掲示板の趣旨に合いません。',
                'posted_at' => Carbon::now()->subDays(1),
                'is_handled' => false, // まだ未対応
            ],
            // 回答に対する報告
            [
                'reported_object_type' => 'App\\Models\\Answer', // 報告対象のモデルのフルパス
                'reported_object_id' => $answerToReport->id, // 報告対象のID
                'reporter_user_id' => $user1->id, // 報告したユーザー (testuser1)
                'report_reason' => 'スパム',
                'report_comment' => '宣伝のような内容が含まれています。',
                'posted_at' => Carbon::now()->subHours(5),
                'is_handled' => false, // まだ未対応
            ],
            // 管理者による既に処理済みの報告
            [
                'reported_object_type' => 'App\\Models\\Question',
                'reported_object_id' => $questionToReport->id,
                'reporter_user_id' => $adminUser->id, // 管理者が自分で報告して処理済みにするテストケース
                'report_reason' => 'その他',
                'report_comment' => 'テスト用の報告。すでに管理者により確認済み。',
                'posted_at' => Carbon::now()->subDays(3),
                'is_handled' => true, // 処理済み
            ],
        ]);
    }
}