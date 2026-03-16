<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();  // hero, services_intro, about_intro, cta, etc.
            $table->json('title')->nullable();       // translatable
            $table->json('subtitle')->nullable();    // translatable
            $table->json('content')->nullable();     // translatable - rich text
            $table->json('button_text')->nullable(); // translatable
            $table->string('button_link')->nullable();
            $table->string('image')->nullable();
            $table->json('extra')->nullable(); // any extra JSON data
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_sections');
    }
};
