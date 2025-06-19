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
        Schema::create('questions', function (Blueprint $table) {
            $table->id(); // id INT AUTO_INCREMENT PRIMARY KEY

            // 質問タイトル
            // 論理名: 質問タイトル, 物理名: title, データ型: VARCHAR(255), Not Null: ●
            $table->string('title', 255)->comment('質問タイトル');

            // 質問本文
            // 論理名: 質問本文, 物理名: content, データ型: TEXT, Not Null: ●
            $table->text('content')->comment('質問本文');

            // 画像パス
            // 論理名: 画像パス, 物理名: image_path, データ型: VARCHAR(255), Not Null: -
            $table->string('image_path', 255)->nullable()->comment('画像パス'); // ここがnullable()になっているか確認！

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
                  ->onDelete('cascade')  // 関連するユーザーが削除されたら質問も削除 (任意, 必要に応じて変更)
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
        Schema::dropIfExists('questions');
    }
};