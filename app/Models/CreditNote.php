<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditNote extends Model
{
    protected $fillable = [
        'client_id',
        'invoice_id',
        'credit_number',
        'issue_date',
        'amount',
        'reason',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'issue_date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public static function generateNumber(): string
    {
        $year = date('Y');
        $last = static::whereYear('created_at', $year)->max('credit_number');
        $num = $last ? ((int) substr($last, -4)) + 1 : 1;
        return "CN-{$year}-" . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
