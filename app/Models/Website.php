<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Website extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'domain',
        'hosting_provider',
        'hosting_expiry',
        'domain_expiry',
        'tech_stack',
        'status',
        'monthly_cost',
        'notes',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'hosting_expiry' => 'date',
        'domain_expiry' => 'date',
        'monthly_cost' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Check if hosting or domain is expiring within 30 days.
     */
    public function getIsExpiringSoonAttribute(): bool
    {
        $threshold = now()->addDays(30);
        return ($this->hosting_expiry && $this->hosting_expiry->lte($threshold))
            || ($this->domain_expiry && $this->domain_expiry->lte($threshold));
    }
}
