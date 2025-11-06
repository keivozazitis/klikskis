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
            $table->id();
            
            // Ziņotais lietotājs
            $table->foreignId('reported_user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Lietotājs, kas ziņo
            $table->foreignId('reporter_user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Iemesls
            $table->enum('reason', ['underage','impersonation','pornographic']);

            $table->timestamps();
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
