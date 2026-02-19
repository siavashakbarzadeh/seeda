<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('case_studies', function (Blueprint $table) {
            $table->string('thumbnail')->nullable()->after('color');
            $table->string('client_name')->nullable()->after('thumbnail');
            $table->string('client_logo')->nullable()->after('client_name');
            $table->string('live_url')->nullable()->after('client_logo');
            $table->string('duration')->nullable()->after('live_url');
            $table->json('technologies')->nullable()->after('duration');
            $table->text('testimonial_text')->nullable()->after('technologies');
            $table->string('testimonial_author')->nullable()->after('testimonial_text');
        });
    }

    public function down(): void
    {
        Schema::table('case_studies', function (Blueprint $table) {
            $table->dropColumn([
                'thumbnail',
                'client_name',
                'client_logo',
                'live_url',
                'duration',
                'technologies',
                'testimonial_text',
                'testimonial_author'
            ]);
        });
    }
};
