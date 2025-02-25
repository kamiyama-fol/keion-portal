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
        //
        Schema::create('studio_reservations', function (Blueprint $table){
            $table->id();
            $table->dateTime('use_datetime')->unique(); //予約の重複を許さない
            $table->foreignId('studio_id')->constrained('studios');
            $table->foreignId('reserved_user_id')->constrained('users');
            $table->string('reserved_band_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('studio_reservations');
    }
};
