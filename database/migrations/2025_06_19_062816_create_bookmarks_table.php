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
        // bookmarks テーブルは user_id と question_id の複合主キーを持つ中間テーブルです。
        // Laravelの慣例により、id カラムは自動生成されません。
        Schema::create('bookmarks', function (Blueprint $table) {
            // ユーザーID (複合主キー、外部キー)
            // 論理名: ユーザーID, 物理名: user_id, データ型: INT, Not Null: ●
            // users テーブルの id を参照する外部キー制約を設定します。
            $table->foreignId('user_id')
                  ->constrained('users')     // 'users' テーブルの 'id' カラムを参照
                  ->onDelete('cascade')      // 関連するユーザーが削除されたらブックマークも削除
                  ->comment('ユーザーID');

            // 質問ID (複合主キー、外部キー)
            // 論理名: 質問ID, 物理名: question_id, データ型: INT, Not Null: ●
            // questions テーブルの id を参照する外部キー制約を設定します。
            $table->foreignId('question_id')
                  ->constrained('questions') // 'questions' テーブルの 'id' カラムを参照
                  ->onDelete('cascade')      // 関連する質問が削除されたらブックマークも削除
                  ->comment('質問ID');

            // 複合主キーの設定
            // user_id と question_id の組み合わせが一意になるようにします。
            $table->primary(['user_id', 'question_id']);

            // ブックマーク日時
            // 論理名: ブックマーク日時, 物理名: posted_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP
            $table->timestamp('posted_at')->useCurrent()->comment('ブックマーク日時');

            // 中間テーブルでは timestamps() メソッドは通常使いません。
            // 履歴情報としての更新日時が不要であれば updated_at も不要です。
            // 今回の定義書には updated_at がないので含めません。
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};