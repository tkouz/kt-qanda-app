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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // user_id INT AUTO_INCREMENT PRIMARY KEY

            // ユーザー名
            // 論理名: ユーザー名, 物理名: username, データ型: VARCHAR(255), Not Null: ●, UNIQUE
            $table->string('username')->unique()->comment('ユーザー名');

            // メールアドレス
            // 論理名: メールアドレス, 物理名: email, データ型: VARCHAR(255), Not Null: ●, UNIQUE
            $table->string('email')->unique()->comment('メールアドレス');

            // パスワードハッシュ
            // 論理名: パスワードハッシュ, 物理名: password_hash, データ型: VARCHAR(255), Not Null: ●
            $table->string('password_hash')->comment('パスワードハッシュ');

            // プロフィール画像パス (nullable)
            // 論理名: プロフィール画像パス, 物理名: profile_image, データ型: VARCHAR(255), Not Null: -
            $table->string('profile_image')->nullable()->comment('プロフィール画像パス');

            // 自己紹介文 (nullable)
            // 論理名: 自己紹介文, 物理名: self_introduction, データ型: TEXT, Not Null: -
            $table->text('self_introduction')->nullable()->comment('自己紹介文');

            // 最終ログイン日時
            // 論理名: 最終ログイン日時, 物理名: last_login_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP
            $table->timestamp('last_login_at')->useCurrent()->comment('最終ログイン日時');

            // 登録日時
            // 論理名: 登録日時, 物理名: registered_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP
            $table->timestamp('registered_at')->useCurrent()->comment('登録日時');

            // 更新日時
            // 論理名: 更新日時, 物理名: updated_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');

            // ユーザー権限
            // 論理名: ユーザー権限, 物理名: role, データ型: ENUM('admin','general'), Not Null: ●, デフォルト値: 'general'
            $table->enum('role', ['admin', 'general'])->default('general')->comment('ユーザー権限');

            // 有効/無効フラグ
            // 論理名: 有効/無効フラグ, 物理名: is_active, データ型: BOOLEAN, Not Null: ●, デフォルト値: TRUE
            $table->boolean('is_active')->default(true)->comment('有効/無効フラグ');

            // パスワードリセットトークン (nullable)
            // 論理名: パスワードリセットトークン, 物理名: password_reset_token, データ型: VARCHAR(255), Not Null: -
            $table->string('password_reset_token')->nullable()->comment('パスワードリセットトークン');

            // パスワードリセットトークン有効期限 (nullable)
            // 論理名: パスワードリセットトークン有効期限, 物理名: password_reset_expires_at, データ型: DATETIME, Not Null: -
            $table->timestamp('password_reset_expires_at')->nullable()->comment('パスワードリセットトークン有効期限');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};