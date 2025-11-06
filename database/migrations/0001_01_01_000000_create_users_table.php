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
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->boolean('is_admin')->default(false);
            $table->integer('weight')->nullable(); // kg
            $table->text('bio')->nullable();
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('cascade');
            $table->integer('augums')->nullable(); // cm
            $table->json('images')->nullable();

            // ✅ Jaunais lauks tagiem
            // Šeit tiks saglabāti, piemēram: "Freakclick,Smēķēju,Sportoju"
            $table->string('tags')->nullable();

            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
