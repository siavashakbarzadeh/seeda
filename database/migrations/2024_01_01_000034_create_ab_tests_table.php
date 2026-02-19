<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('variant_a_label')->default('Variant A');
            $table->string('variant_b_label')->default('Variant B');
            $table->integer('variant_a_views')->default(0);
            $table->integer('variant_b_views')->default(0);
            $table->integer('variant_a_conversions')->default(0);
            $table->integer('variant_b_conversions')->default(0);
            $table->enum('status', ['draft', 'running', 'completed'])->default('draft');
            $table->string('winner')->nullable(); // 'a', 'b', or null
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ab_tests');
    }
};
