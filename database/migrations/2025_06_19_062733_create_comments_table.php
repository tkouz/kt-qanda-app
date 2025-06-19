<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // id INT AUTO_INCREMENT PRIMARY KEY

            // 回答ID (外部キー)
            // 論理名: 回答ID, 物理名: answer_id, データ型: INT, Not Null: ●
            // answers テーブルの id を参照する外部キー制約を設定します。
            $table->foreignId('answer_id')
                  ->constrained('answers') // 'answers' テーブルの 'id' カラムを参照
                  ->onDelete('cascade')    // 関連する回答が削除されたらコメントも削除 (任意, 必要に応じて変更)
                  ->comment('回答ID');

            // コメント本文
            // 論理名: コメント本文, 物理名: content, データ型: TEXT, Not Null: ●
            $table->text('content')->comment('コメント本文');

            // 投稿日時
            // 論理名: 投稿日時, 物理名: posted_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP
            $table->timestamp('posted_at')->useCurrent()->comment('投稿日時');

            // 更新日時
            // 論理名: 更新日時, 物理名: updated_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            // 要件定義書に「回答コメント（CRUD③）は編集・削除不可」とありますが、
            // 今後の拡張性やLaravelの慣習（timestamps()の自動更新）を考慮し、updated_atは含めています。
            // アプリケーション側で編集機能を無効にすることで対応可能です。
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');

            // ユーザーID (外部キー)
            // 論理名: ユーザーID, 物理名: user_id, データ型: INT, Not Null: ●
            // users テーブルの id を参照する外部キー制約を設定します。
            $table->foreignId('user_id')
                  ->constrained('users') // 'users' テーブルの 'id' カラムを参照
                  ->onDelete('cascade')  // 関連するユーザーが削除されたらコメントも削除 (任意, 必要に応じて変更)
                  ->comment('ユーザーID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};