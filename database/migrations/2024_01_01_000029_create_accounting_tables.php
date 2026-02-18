<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── Payments ──
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->date('payment_date');
            $table->enum('method', ['bank_transfer', 'credit_card', 'paypal', 'cash', 'check', 'other'])->default('bank_transfer');
            $table->string('reference')->nullable();         // Transaction ref / check number
            $table->text('notes')->nullable();
            $table->string('receipt_path')->nullable();
            $table->timestamps();
        });

        // ── Recurring Invoice Templates ──
        Schema::create('recurring_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('frequency', ['weekly', 'monthly', 'quarterly', 'yearly'])->default('monthly');
            $table->decimal('amount', 12, 2);
            $table->decimal('tax_rate', 5, 2)->default(22);
            $table->json('items')->nullable();                // [{description, qty, unit_price}]
            $table->date('next_issue_date');
            $table->date('end_date')->nullable();
            $table->integer('occurrences_left')->nullable();  // null = infinite
            $table->boolean('is_active')->default(true);
            $table->boolean('auto_send')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // ── Credit Notes ──
        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->string('credit_number')->unique();
            $table->date('issue_date');
            $table->decimal('amount', 12, 2);
            $table->text('reason');
            $table->enum('status', ['draft', 'issued', 'applied', 'refunded'])->default('draft');
            $table->timestamps();
        });

        // Add extra fields to invoices
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('amount_paid', 12, 2)->default(0)->after('total');
            $table->decimal('balance_due', 12, 2)->default(0)->after('amount_paid');
            $table->foreignId('recurring_invoice_id')->nullable()->after('balance_due');
            $table->string('payment_terms')->nullable()->after('notes');
            $table->string('currency', 3)->default('EUR')->after('payment_terms');
            $table->decimal('discount_amount', 12, 2)->default(0)->after('currency');
            $table->string('discount_type')->nullable()->after('discount_amount'); // percentage or fixed
            $table->timestamp('sent_at')->nullable()->after('paid_at');
            $table->timestamp('reminder_sent_at')->nullable()->after('sent_at');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'amount_paid',
                'balance_due',
                'recurring_invoice_id',
                'payment_terms',
                'currency',
                'discount_amount',
                'discount_type',
                'sent_at',
                'reminder_sent_at',
            ]);
        });
        Schema::dropIfExists('credit_notes');
        Schema::dropIfExists('recurring_invoices');
        Schema::dropIfExists('payments');
    }
};
