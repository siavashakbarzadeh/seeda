<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── Social Media Posts ──
        Schema::create('social_media_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('platform');                           // instagram, facebook, linkedin, twitter, tiktok, youtube
            $table->enum('status', ['draft', 'scheduled', 'published', 'failed'])->default('draft');
            $table->string('media_url')->nullable();              // image/video path
            $table->string('post_url')->nullable();               // live post URL after publishing
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->integer('likes')->default(0);
            $table->integer('comments')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('hashtags')->nullable();
            $table->timestamps();
        });

        // ── SEO Keywords ──
        Schema::create('seo_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword');
            $table->string('target_page')->nullable();            // URL being tracked
            $table->integer('current_position')->nullable();
            $table->integer('previous_position')->nullable();
            $table->integer('best_position')->nullable();
            $table->integer('search_volume')->nullable();         // monthly searches
            $table->decimal('difficulty', 5, 2)->nullable();      // 0-100
            $table->decimal('cpc', 8, 2)->nullable();             // estimated cost per click
            $table->enum('status', ['tracking', 'paused', 'archived'])->default('tracking');
            $table->foreignId('campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamps();
        });

        // ── Lead Activities / Notes ──
        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');                               // note, call, email, meeting, proposal, follow_up, status_change
            $table->text('description');
            $table->json('metadata')->nullable();                 // extra data (duration, result, etc.)
            $table->timestamp('scheduled_at')->nullable();        // for follow-ups
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });

        // ── Add lead scoring fields ──
        Schema::table('leads', function (Blueprint $table) {
            $table->integer('score')->default(0)->after('estimated_value');
            $table->string('priority')->default('medium')->after('score');  // low, medium, high, urgent
            $table->string('industry')->nullable()->after('website');
            $table->string('company_size')->nullable()->after('industry'); // 1-10, 11-50, 51-200, 201-500, 500+
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['score', 'priority', 'industry', 'company_size']);
        });
        Schema::dropIfExists('lead_activities');
        Schema::dropIfExists('seo_keywords');
        Schema::dropIfExists('social_media_posts');
    }
};
