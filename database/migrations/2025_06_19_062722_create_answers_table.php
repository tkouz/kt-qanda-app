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
        Schema::create('answers', function (Blueprint $table) {
            $table->id(); // id INT AUTO_INCREMENT PRIMARY KEY

            // 質問ID (外部キー)
            // 論理名: 質問ID, 物理名: question_id, データ型: INT, Not Null: ●
            // questions テーブルの id を参照する外部キー制約を設定します。
            $table->foreignId('question_id')
                  ->constrained('questions') // 'questions' テーブルの 'id' カラムを参照
                  ->onDelete('cascade')      // 関連する質問が削除されたら回答も削除 (任意, 必要に応じて変更)
                  ->comment('質問ID');

            // 回答本文
            // 論理名: 回答本文, 物理名: content, データ型: TEXT, Not Null: ●
            $table->text('content')->comment('回答本文');

            // 画像パス
            // 論理名: 画像パス, 物理名: image_path, データ型: VARCHAR(255), Not Null: - (NULL許容)
            // 定義書通りNULL許容です。
            $table->string('image_path', 255)->nullable()->comment('画像パス');

            // 投稿日時
            // 論理名: 投稿日時, 物理名: posted_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP
            $table->timestamp('posted_at')->useCurrent()->comment('投稿日時');

            // 更新日時
            // 論理名: 更新日時, 物理名: updated_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');

            // ユーザーID (外部キー)
            // 論理名: ユーザーID, 物理名: user_id, データ型: INT, Not Null: ●
            // users テーブルの id を参照する外部キー制約を設定します。
            $table->foreignId('user_id')
                  ->constrained('users') // 'users' テーブルの 'id' カラムを参照
                  ->onDelete('cascade')  // 関連するユーザーが削除されたら回答も削除 (任意, 必要に応じて変更)
                  ->comment('ユーザーID');

            // 表示フラグ
            // 論理名: 表示フラグ, 物理名: is_visible, データ型: BOOLEAN, Not Null: ●, デフォルト値: TRUE
            $table->boolean('is_visible')->default(true)->comment('表示フラグ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};