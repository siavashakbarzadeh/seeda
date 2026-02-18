<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('domain')->nullable();
            $table->string('hosting_provider')->nullable();
            $table->date('hosting_expiry')->nullable();
            $table->date('domain_expiry')->nullable();
            $table->json('tech_stack')->nullable();
            $table->enum('status', ['active', 'maintenance', 'development', 'suspended', 'archived'])->default('active');
            $table->decimal('monthly_cost', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
