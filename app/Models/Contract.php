<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    protected $fillable = [
        'client_id',
        'project_id',
        'title',
        'type',
        'value',
        'start_date',
        'end_date',
        'status',
        'file_path',
        'notes',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->end_date && $this->end_date->lt(now());
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
