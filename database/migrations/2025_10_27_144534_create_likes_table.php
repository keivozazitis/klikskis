<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('liked_user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('matched')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'liked_user_id']); // viena like tikai reizi
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
