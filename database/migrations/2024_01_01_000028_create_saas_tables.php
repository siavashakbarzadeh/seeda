<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── Activity Log (skip if already exists from migration 000021) ──
        if (!Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
                $table->string('type');
                $table->string('description');
                $table->json('properties')->nullable();
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();
            });
        }

        // ── API Keys ──
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('key', 64)->unique();
            $table->string('secret_hash');
            $table->json('permissions')->nullable();  // ["read:projects", "write:tickets"]
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── Usage Tracking ──
        Schema::create('usage_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('metric');             // api_calls, storage_bytes, projects, tickets
            $table->bigInteger('quantity')->default(0);
            $table->date('period_start');
            $table->date('period_end');
            $table->timestamps();

            $table->index(['client_id', 'metric', 'period_start']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usage_records');
        Schema::dropIfExists('api_keys');
        Schema::dropIfExists('activity_logs');
    }
};
