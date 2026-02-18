<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add extra fields to tickets
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('category')->nullable()->after('subject');
            $table->json('tags')->nullable()->after('category');
            $table->timestamp('first_responded_at')->nullable()->after('closed_at');
            $table->unsignedInteger('sla_hours')->nullable()->after('first_responded_at');
            $table->tinyInteger('satisfaction_rating')->nullable()->after('sla_hours');
            $table->text('satisfaction_comment')->nullable()->after('satisfaction_rating');
            $table->string('source')->default('portal')->after('satisfaction_comment'); // portal, email, phone, admin
        });

        // Add attachments to replies
        Schema::table('ticket_replies', function (Blueprint $table) {
            $table->json('attachments')->nullable()->after('body');
        });

        // Standalone ticket attachments table
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ticket_reply_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->default(0);
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_attachments');

        Schema::table('ticket_replies', function (Blueprint $table) {
            $table->dropColumn('attachments');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'tags',
                'first_responded_at',
                'sla_hours',
                'satisfaction_rating',
                'satisfaction_comment',
                'source',
            ]);
        });
    }
};
