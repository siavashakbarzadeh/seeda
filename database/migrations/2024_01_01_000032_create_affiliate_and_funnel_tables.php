<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── Partners (Affiliates) ──
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('code')->unique();
            $table->decimal('commission_rate', 5, 2)->default(10.00);
            $table->enum('type', ['individual', 'agency'])->default('individual');
            $table->enum('status', ['active', 'pending', 'suspended'])->default('active');
            $table->decimal('balance', 12, 2)->default(0);
            $table->decimal('total_earned', 12, 2)->default(0);
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        // ── Referrals ──
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('tracking_id')->nullable();
            $table->decimal('payout_amount', 12, 2)->default(0);
            $table->enum('status', ['pending', 'converted', 'payout_pending', 'paid', 'cancelled'])->default('pending');
            $table->boolean('is_recurring')->default(false);
            $table->timestamps();
        });

        // ── Payout Logs ──
        Schema::create('payout_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('method')->default('bank'); // bank, paypal, etc.
            $table->string('reference_no')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        // ── Behavioral Tracking (Interactions) ──
        Schema::create('lead_interactions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->foreignId('lead_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('url');
            $table->string('action'); // view_pricing, download_case_study, exit_intent
            $table->integer('points')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        // ── Lead Magnets / Funnels ──
        Schema::create('marketing_funnels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['case_study', 'price_guide', 'whitepaper']);
            $table->string('file_path')->nullable();
            $table->boolean('is_locked')->default(true);
            $table->integer('conversions')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketing_funnels');
        Schema::dropIfExists('lead_interactions');
        Schema::dropIfExists('payout_logs');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('partners');
    }
};
