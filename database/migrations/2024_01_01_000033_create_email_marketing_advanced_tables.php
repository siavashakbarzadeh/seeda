<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── Email Templates ──
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject');
            $table->longText('content');
            $table->string('category')->default('marketing'); // marketing, sales, support
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── Email Lists (Segments) ──
        Schema::create('email_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });

        // ── Newsletter Subscribers & Lists Pivot ──
        Schema::create('email_list_subscriber', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_list_id')->constrained()->cascadeOnDelete();
            $table->foreignId('newsletter_subscriber_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // Connect existing email campaigns to templates
        Schema::table('email_campaigns', function (Blueprint $table) {
            $table->foreignId('email_template_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('email_list_id')->nullable()->after('email_template_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('email_campaigns', function (Blueprint $table) {
            $table->dropForeign(['email_template_id']);
            $table->dropForeign(['email_list_id']);
            $table->dropColumn(['email_template_id', 'email_list_id']);
        });
        Schema::dropIfExists('email_list_subscriber');
        Schema::dropIfExists('email_lists');
        Schema::dropIfExists('email_templates');
    }
};
