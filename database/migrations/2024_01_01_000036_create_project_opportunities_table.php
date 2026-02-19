<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('client_name')->nullable();
            $table->string('client_email')->nullable();
            $table->string('source'); // upwork, freelancer, linkedin, referral, direct, fiverr, toptal, github, other
            $table->string('source_url')->nullable();
            $table->decimal('budget_min', 12, 2)->nullable();
            $table->decimal('budget_max', 12, 2)->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->enum('budget_type', ['fixed', 'hourly', 'monthly', 'unknown'])->default('unknown');
            $table->json('technologies')->nullable(); // ["laravel", "react", "python", ...]
            $table->enum('status', ['found', 'applied', 'interviewing', 'proposal_sent', 'won', 'lost', 'passed'])->default('found');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->integer('estimated_hours')->nullable();
            $table->date('deadline')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('applied_at')->nullable();
            $table->timestamp('response_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_opportunities');
    }
};
