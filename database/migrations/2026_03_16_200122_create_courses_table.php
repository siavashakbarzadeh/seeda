<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->json('title');           // translatable
            $table->json('subtitle')->nullable(); // translatable
            $table->json('description');     // translatable
            $table->json('curriculum')->nullable(); // translatable - rich text
            $table->json('career_info')->nullable(); // translatable
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency', 10)->default('EUR');
            $table->string('installment_info')->nullable(); // e.g. "6 months at 0%"
            $table->string('duration')->nullable();          // e.g. "3 months"
            $table->string('level')->nullable();             // beginner, intermediate, advanced
            $table->string('format')->nullable();            // remote, in-person, hybrid
            $table->string('location')->nullable();          // e.g. "Roma, Italy"
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamp('starts_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
