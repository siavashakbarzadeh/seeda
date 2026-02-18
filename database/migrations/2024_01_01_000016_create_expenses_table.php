<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('category', ['software', 'hardware', 'hosting', 'domain', 'marketing', 'travel', 'office', 'subscription', 'freelancer', 'other'])->default('other');
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->string('receipt_path')->nullable();
            $table->boolean('is_reimbursable')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected', 'reimbursed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
