<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'client_id',
        'amount',
        'payment_date',
        'method',
        'reference',
        'notes',
        'receipt_path',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public static function getMethodOptions(): array
    {
        return [
            'bank_transfer' => '🏦 Bank Transfer',
            'credit_card' => '💳 Credit Card',
            'paypal' => '📱 PayPal',
            'cash' => '💵 Cash',
            'check' => '📄 Check',
            'other' => '📋 Other',
        ];
    }

    protected static function booted(): void
    {
        // After payment saved/deleted, update invoice paid amount
        static::saved(fn(Payment $p) => $p->invoice?->syncPayments());
        static::deleted(fn(Payment $p) => $p->invoice?->syncPayments());
    }
}
