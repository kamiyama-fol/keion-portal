<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Band;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // nullのlive_idを持つバンドを削除
        Band::whereNull('live_id')->delete();

        Schema::table('bands', function (Blueprint $table) {
            // 既存の外部キー制約を削除
            $table->dropForeign(['live_id']);

            // live_idカラムを必須に変更
            $table->foreignId('live_id')->nullable(false)->change();

            // 新しい外部キー制約を追加
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
            // 既存の外部キー制約を削除
            $table->dropForeign(['live_id']);

            // live_idカラムをnullableに戻す
            $table->foreignId('live_id')->nullable()->change();

            // 元の外部キー制約を復元
            $table->foreign('live_id')
                ->references('id')
                ->on('lives')
                ->onDelete('cascade');
        });
    }
};
