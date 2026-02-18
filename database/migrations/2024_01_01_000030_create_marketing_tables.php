<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── Leads ──
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('website')->nullable();
            $table->string('source')->default('website');          // website, referral, google, social, cold_call, event, other
            $table->enum('status', ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'won', 'lost'])->default('new');
            $table->decimal('estimated_value', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('campaign_id')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->timestamp('last_contacted_at')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete(); // linked after conversion
            $table->timestamps();
        });

        // ── Campaigns ──
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');                                // google_ads, facebook, instagram, email, linkedin, seo, referral, event, other
            $table->enum('status', ['draft', 'active', 'paused', 'completed', 'cancelled'])->default('draft');
            $table->decimal('budget', 12, 2)->nullable();
            $table->decimal('spent', 12, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->string('target_url')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->integer('conversions')->default(0);
            $table->decimal('revenue_generated', 12, 2)->default(0);
            $table->json('tags')->nullable();
            $table->timestamps();
        });

        // ── Contact Form Submissions ──
        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('source_page')->nullable();             // which page the form was on
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->enum('status', ['new', 'read', 'replied', 'spam', 'archived'])->default('new');
            $table->foreignId('lead_id')->nullable();              // linked to lead after processing
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        // ── Email Campaigns (bulk emails to subscribers) ──
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject');
            $table->text('body');
            $table->enum('status', ['draft', 'scheduled', 'sending', 'sent', 'cancelled'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->integer('recipients_count')->default(0);
            $table->integer('opened_count')->default(0);
            $table->integer('clicked_count')->default(0);
            $table->integer('bounced_count')->default(0);
            $table->integer('unsubscribed_count')->default(0);
            $table->timestamps();
        });

        // Add campaign_id FK to leads
        Schema::table('leads', function (Blueprint $table) {
            $table->foreign('campaign_id')->references('id')->on('campaigns')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['campaign_id']);
        });
        Schema::dropIfExists('email_campaigns');
        Schema::dropIfExists('contact_submissions');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('leads');
    }
};
