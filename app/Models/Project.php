<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'slug',
        'description',
        'status',
        'priority',
        'budget',
        'hourly_rate',
        'start_date',
        'deadline',
        'completed_at',
        'progress',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
        'start_date' => 'date',
        'deadline' => 'date',
        'completed_at' => 'datetime',
        'progress' => 'integer',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function getTotalHoursAttribute(): float
    {
        return $this->timeEntries()->sum('hours');
    }

    public function getTotalCostAttribute(): float
    {
        return $this->total_hours * ($this->hourly_rate ?? 0);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->deadline
            && $this->deadline->lt(now())
            && !in_array($this->status, ['completed', 'cancelled']);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['planning', 'in_progress', 'review']);
    }
}
