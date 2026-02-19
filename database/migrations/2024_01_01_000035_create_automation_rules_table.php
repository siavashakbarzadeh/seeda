<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('automation_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('trigger'); // lead_created, score_reached, status_changed, form_submitted, interaction_recorded
            $table->json('conditions')->nullable(); // e.g. {"score_min": 50, "source": "google"}
            $table->json('actions'); // e.g. [{"type": "send_email", "template_id": 1}, {"type": "assign_user", "user_id": 3}]
            $table->boolean('is_active')->default(true);
            $table->integer('executions_count')->default(0);
            $table->timestamp('last_executed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('automation_rules');
    }
};
