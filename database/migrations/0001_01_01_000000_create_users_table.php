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
            $table->id(); // id INT AUTO_INCREMENT PRIMARY KEY

            // ユーザー名
            // 論理名: ユーザー名, 物理名: username, データ型: VARCHAR(255), Not Null: ●
            $table->string('username', 255)->comment('ユーザー名');

            // メールアドレス
            // 論理名: メールアドレス, 物理名: email, データ型: VARCHAR(255), Not Null: ●, 特徴: UNIQUE
            $table->string('email', 255)->unique()->comment('メールアドレス');

            // パスワードハッシュ
            // 論理名: パスワードハッシュ, 物理名: password_hash, データ型: VARCHAR(255), Not Null: ●
            // Laravelのデフォルトは 'password' というカラム名ですが、定義書に合わせて 'password_hash' に変更します。
            $table->string('password_hash', 255)->comment('パスワードハッシュ');

            // プロフィール画像パス
            // 論理名: プロフィール画像パス, 物理名: profile_image, データ型: VARCHAR(255), Not Null: - (NULL許容)
            $table->string('profile_image', 255)->nullable()->comment('プロフィール画像パス');

            // 自己紹介文
            // 論理名: 自己紹介文, 物理名: self_introduction, データ型: TEXT, Not Null: - (NULL許容)
            $table->text('self_introduction')->nullable()->comment('自己紹介文');

            // 最終ログイン日時
            // 論理名: 最終ログイン日時, 物理名: last_login_at, データ型: DATETIME, Not Null: - (NULL許容)
            $table->timestamp('last_login_at')->nullable()->comment('最終ログイン日時');

            // 登録日時
            // 論理名: 登録日時, 物理名: posted_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP
            $table->timestamp('posted_at')->useCurrent()->comment('登録日時');

            // 更新日時
            // 論理名: 更新日時, 物理名: updated_at, データ型: DATETIME, Not Null: ●, デフォルト値: CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('更新日時');

            // ユーザーロール
            // 論理名: ユーザーロール, 物理名: role, データ型: ENUM('general', 'admin'), Not Null: ●, デフォルト値: 'general'
            $table->enum('role', ['general', 'admin'])->default('general')->comment('ユーザーロール');

            // 有効フラグ
            // 論理名: 有効フラグ, 物理名: is_active, データ型: BOOLEAN, Not Null: ●, デフォルト値: TRUE
            $table->boolean('is_active')->default(true)->comment('有効フラグ');

            // パスワードリセットトークン
            // 論理名: パスワードリセットトークン, 物理名: password_reset_token, データ型: VARCHAR(255), Not Null: - (NULL許容)
            $table->string('password_reset_token', 255)->nullable()->comment('パスワードリセットトークン');

            // パスワードリセットトークン有効期限
            // 論理名: パスワードリセットトークン有効期限, 物理名: password_reset_expires_at, データ型: DATETIME, Not Null: - (NULL許容)
            $table->timestamp('password_reset_expires_at')->nullable()->comment('パスワードリセットトークン有効期限');

            // Laravelデフォルトの不要なカラムは削除
            // $table->timestamp('email_verified_at')->nullable(); // 削除
            // $table->rememberToken(); // 削除
            // $table->timestamps(); // posted_at と updated_at で代用するため削除
        });

        // password_reset_tokens と sessions テーブルは、このマイグレーションファイルから削除します。
        // なぜなら、あなたのテーブル定義書にはこれらのテーブルが直接定義されていないためです。
        // パスワードリセット機能は users テーブルの password_reset_token と password_reset_expires_at で管理し、
        // セッション管理は Laravel が提供する他の方法（ファイル、データベース、Redisなど）を利用します。
        // もし別途 password_reset_tokens と sessions のテーブル定義がある場合は、別途マイグレーションファイルを生成して対応します。
        // 現時点では、この users テーブルのマイグレーションファイルからは削除します。
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        // Schema::dropIfExists('password_reset_tokens'); // 削除
        // Schema::dropIfExists('sessions'); // 削除
    }
};