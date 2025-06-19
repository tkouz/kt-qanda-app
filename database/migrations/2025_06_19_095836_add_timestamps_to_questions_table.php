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
        Schema::table('questions', function (Blueprint $table) {
            // created_at と updated_at カラムを追加
            $table->timestamps(); // これでcreated_atとupdated_atの両方が追加されます
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            // ロールバック時にカラムを削除
            $table->dropTimestamps();
        });
    }
};