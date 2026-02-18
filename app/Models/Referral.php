<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Referral extends Model
{
    protected $fillable = [
        'partner_id',
        'lead_id',
        'client_id',
        'project_id',
        'tracking_id',
        'payout_amount',
        'status',
        'is_recurring'
    ];

    protected $casts = [
        'payout_amount' => 'decimal:2',
        'is_recurring' => 'boolean',
    ];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }
}
