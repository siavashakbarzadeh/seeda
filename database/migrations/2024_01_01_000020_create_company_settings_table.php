<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
        });

        // Seed defaults
        $defaults = [
            'company_name' => 'Seeda',
            'company_email' => 'info@seeda.dev',
            'company_phone' => '',
            'company_address' => '',
            'company_vat' => '',
            'company_logo' => '',
            'invoice_prefix' => 'INV-',
            'invoice_footer' => 'Thank you for your business!',
            'default_currency' => 'EUR',
            'default_tax_rate' => '22',
        ];

        foreach ($defaults as $key => $value) {
            \DB::table('company_settings')->insert(['key' => $key, 'value' => $value]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('company_settings');
    }
};
