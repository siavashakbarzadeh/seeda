<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'total',
        'amount_paid',
        'balance_due',
        'recurring_invoice_id',
        'payment_terms',
        'currency',
        'discount_amount',
        'discount_type',
        'status',
        'notes',
        'paid_at',
        'sent_at',
        'reminder_sent_at',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'sent_at' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    // ── Relations ──

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function creditNotes(): HasMany
    {
        return $this->hasMany(CreditNote::class);
    }

    public function recurringInvoice(): BelongsTo
    {
        return $this->belongsTo(RecurringInvoice::class);
    }

    // ── Calculations ──

    public function recalculate(): void
    {
        $subtotal = $this->items()->sum(\DB::raw('quantity * unit_price'));

        // Apply discount
        $discount = 0;
        if ($this->discount_amount > 0) {
            $discount = $this->discount_type === 'percentage'
                ? $subtotal * ($this->discount_amount / 100)
                : $this->discount_amount;
        }

        $taxableAmount = $subtotal - $discount;
        $taxAmount = $taxableAmount * ($this->tax_rate / 100);
        $total = $taxableAmount + $taxAmount;

        $this->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'balance_due' => $total - $this->amount_paid,
        ]);
    }

    public function syncPayments(): void
    {
        $paid = $this->payments()->sum('amount');
        $balanceDue = $this->total - $paid;

        $status = $this->status;
        if ($paid >= $this->total && $this->total > 0) {
            $status = 'paid';
        } elseif ($paid > 0 && $paid < $this->total) {
            $status = 'partial';
        }

        $this->update([
            'amount_paid' => $paid,
            'balance_due' => max(0, $balanceDue),
            'status' => $status,
            'paid_at' => $status === 'paid' ? ($this->paid_at ?? now()) : null,
        ]);
    }

    // ── Helpers ──

    public static function generateNumber(): string
    {
        $year = date('Y');
        $last = static::whereYear('created_at', $year)->max('invoice_number');
        $num = $last ? ((int) substr($last, -4)) + 1 : 1;
        return "INV-{$year}-" . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    public function getIsOverdueAttribute(): bool
    {
        return !in_array($this->status, ['paid', 'cancelled'])
            && $this->due_date
            && $this->due_date->lt(now());
    }

    public function getPaymentProgressAttribute(): int
    {
        if ($this->total <= 0)
            return 0;
        return min(100, (int) round(($this->amount_paid / $this->total) * 100));
    }

    public function getDaysUntilDueAttribute(): ?int
    {
        if (!$this->due_date)
            return null;
        return (int) now()->diffInDays($this->due_date, false);
    }

    public function getDueStatusAttribute(): string
    {
        if ($this->status === 'paid')
            return 'paid';
        if (!$this->due_date)
            return 'no_due_date';
        $days = $this->days_until_due;
        if ($days < 0)
            return 'overdue';
        if ($days <= 7)
            return 'due_soon';
        return 'on_track';
    }

    // ── Scopes ──

    public function scopeUnpaid($query)
    {
        return $query->whereNotIn('status', ['paid', 'cancelled', 'draft']);
    }

    public function scopeOverdue($query)
    {
        return $query->unpaid()->where('due_date', '<', now()->toDateString());
    }

    public function scopeByMonth($query, int $year, int $month)
    {
        return $query->whereYear('issue_date', $year)->whereMonth('issue_date', $month);
    }

    public function scopeThisMonth($query)
    {
        return $query->byMonth(now()->year, now()->month);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('issue_date', now()->year);
    }
}
