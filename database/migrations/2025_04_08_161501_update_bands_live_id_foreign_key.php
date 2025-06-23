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
        Schema::table('bands', function (Blueprint $table) {
            // 既存の外部キー制約を削除
            $table->dropForeign(['live_id']);

            // 新しい外部キー制約を追加（onDelete('cascade')を設定）
            $table->foreign('live_id')
                ->references('id')
                ->on('lives')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bands', function (Blueprint $table) {
            // 新しい外部キー制約を削除
            $table->dropForeign(['live_id']);

            // 元の外部キー制約を復元
            $table->foreign('live_id')
                ->references('id')
                ->on('lives');
        });
    }
};
