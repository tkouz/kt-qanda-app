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

            // 報告対象タイプ
            // 論理名: 報告対象タイプ, 物理名: reported_object_type, データ型: ENUM('question','answer'), Not Null: ●
            $table->enum('reported_object_type', ['question', 'answer'])->comment('報告対象タイプ');

            // 報告対象ID
            // 論理名: 報告対象ID, 物理名: reported_object_id, データ型: INT, Not Null: ●
            // このカラムは、reported_object_type に応じて questions.id または answers.id を保持します。
            // データベースレベルでの直接的な外部キー制約は設定しません。（ポリモーフィックリレーションで対応）
            $table->unsignedBigInteger('reported_object_id')->comment('報告対象ID');

            // 報告者ユーザーID (外部キー)
            // 論理名: 報告者ユーザーID, 物理名: reporter_user_id, データ型: INT, Not Null: ●
            // users テーブルの id を参照する外部キー制約を設定します。
            $table->foreignId('reporter_user_id')
                  ->constrained('users') // 'users' テーブルの 'id' カラムを参照
                  ->onDelete('cascade')  // 関連するユーザーが削除されたら報告も削除 (任意, 必要に応じて変更)
                  ->comment('報告者ユーザーID');

            // 報告理由
            // 論理名: 報告理由, 物理名: report_reason, データ型: VARCHAR(255), Not Null: ●
            // 選択式とのことなので、具体的な理由をアプリケーション側で管理するか、enum型にするか検討が必要です。
            // ここでは汎用的にVARCHAR(255)としています。
            $table->string('report_reason', 255)->comment('報告理由');

            // 報告コメント
            // 論理名: 報告コメント, 物理名: report_comment, データ型: TEXT, Not Null: - (NULL許容)
            $table->text('report_comment')->nullable()->comment('報告コメント');

            // 報告日時
            // 論理名: 報告日時, 物理名: posted_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP
            $table->timestamp('posted_at')->useCurrent()->comment('報告日時');

            // 処理済フラグ
            // 論理名: 処理済フラグ, 物理名: is_handled, データ型: BOOLEAN, Not Null: ●, デフォルト値: FALSE
            $table->boolean('is_handled')->default(false)->comment('処理済フラグ');

            // 報告対象の質問または回答のIDとタイプを組み合わせたユニークインデックス (任意: 重複報告防止)
            // これにより、同じユーザーが同じオブジェクトに複数回違反報告するのを防ぐことができます。
            // 必要なければ削除しても構いません。
            // $table->unique(['reported_object_type', 'reported_object_id', 'reporter_user_id'], 'unique_report');
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