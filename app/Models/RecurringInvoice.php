<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecurringInvoice extends Model
{
    protected $fillable = [
        'client_id',
        'title',
        'frequency',
        'amount',
        'tax_rate',
        'items',
        'next_issue_date',
        'end_date',
        'occurrences_left',
        'is_active',
        'auto_send',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'items' => 'array',
        'next_issue_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'auto_send' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function generateInvoice(): Invoice
    {
        $subtotal = $this->amount;
        $taxAmount = $subtotal * ($this->tax_rate / 100);

        $invoice = Invoice::create([
            'client_id' => $this->client_id,
            'invoice_number' => Invoice::generateNumber(),
            'issue_date' => $this->next_issue_date,
            'due_date' => $this->next_issue_date->copy()->addDays(30),
            'subtotal' => $subtotal,
            'tax_rate' => $this->tax_rate,
            'tax_amount' => $taxAmount,
            'total' => $subtotal + $taxAmount,
            'balance_due' => $subtotal + $taxAmount,
            'status' => 'draft',
            'recurring_invoice_id' => $this->id,
            'notes' => $this->notes,
        ]);

        // Create line items
        if ($this->items) {
            foreach ($this->items as $item) {
                $invoice->items()->create([
                    'description' => $item['description'] ?? 'Service',
                    'quantity' => $item['quantity'] ?? 1,
                    'unit_price' => $item['unit_price'] ?? $this->amount,
                ]);
            }
        }

        // Advance next issue date
        $this->update([
            'next_issue_date' => match ($this->frequency) {
                'weekly' => $this->next_issue_date->addWeek(),
                'monthly' => $this->next_issue_date->addMonth(),
                'quarterly' => $this->next_issue_date->addMonths(3),
                'yearly' => $this->next_issue_date->addYear(),
            },
            'occurrences_left' => $this->occurrences_left !== null ? $this->occurrences_left - 1 : null,
        ]);

        // Deactivate if ended
        if (
            ($this->occurrences_left !== null && $this->occurrences_left <= 0)
            || ($this->end_date && $this->next_issue_date->gt($this->end_date))
        ) {
            $this->update(['is_active' => false]);
        }

        return $invoice;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDue($query)
    {
        return $query->active()->where('next_issue_date', '<=', now()->toDateString());
    }
}
