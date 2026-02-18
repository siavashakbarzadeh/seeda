<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeEntry extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'task_id',
        'description',
        'hours',
        'date',
        'is_billable',
    ];

    protected $casts = [
        'hours' => 'decimal:2',
        'date' => 'date',
        'is_billable' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function scopeBillable($query)
    {
        return $query->where('is_billable', true);
    }
}
