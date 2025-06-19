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
        Schema::create('reports', function (Blueprint $table) {
            $table->id(); // id INT AUTO_INCREMENT PRIMARY KEY

            // 報告対象オブジェクトタイプ (ポリモーフィックリレーションシップの型)
            // 論理名: 報告対象オブジェクトタイプ, 物理名: reported_object_type, データ型: VARCHAR(512), Not Null: ●
            // クラス名が長くなる可能性があるので、VARCHAR(512) に変更します。
            $table->string('reported_object_type', 512)->comment('報告対象オブジェクトタイプ');

            // 報告対象オブジェクトID (ポリモーフィックリレーションシップのID)
            // 論理名: 報告対象オブジェクトID, 物理名: reported_object_id, データ型: INT, Not Null: ●
            $table->unsignedBigInteger('reported_object_id')->comment('報告対象オブジェクトID');

            // 報告者ユーザーID
            // 論理名: 報告者ユーザーID, 物理名: reporter_user_id, データ型: INT, Not Null: ●
            // users テーブルの id を参照する外部キー制約を設定します。
            $table->foreignId('reporter_user_id')
                  ->constrained('users')
                  ->onDelete('cascade') // 報告者が削除されたら報告も削除
                  ->comment('報告者ユーザーID');

            // 報告理由
            // 論理名: 報告理由, 物理名: report_reason, データ型: VARCHAR(255), Not Null: ●
            $table->string('report_reason', 255)->comment('報告理由'); // これが正しいカラム名

            // 報告コメント (nullable)
            // 論理名: 報告コメント, 物理名: report_comment, データ型: TEXT, Not Null: -
            $table->text('report_comment')->nullable()->comment('報告コメント');

            // 投稿日時
            // 論理名: 投稿日時, 物理名: posted_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP
            $table->timestamp('posted_at')->useCurrent()->comment('投稿日時');

            // 処理済みフラグ
            // 論理名: 処理済みフラグ, 物理名: is_handled, データ型: BOOLEAN, Not Null: ●, デフォルト値: FALSE
            $table->boolean('is_handled')->default(false)->comment('処理済みフラグ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};