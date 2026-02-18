<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadActivity extends Model
{
    protected $fillable = [
        'lead_id',
        'user_id',
        'type',
        'description',
        'metadata',
        'scheduled_at',
        'is_completed',
    ];

    protected $casts = [
        'metadata' => 'array',
        'scheduled_at' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getTypeOptions(): array
    {
        return [
            'note' => '📝 Note',
            'call' => '📞 Phone Call',
            'email' => '📧 Email',
            'meeting' => '🤝 Meeting',
            'proposal' => '📄 Proposal',
            'follow_up' => '🔔 Follow-up',
            'status_change' => '🔄 Status Change',
            'demo' => '💻 Demo',
            'task' => '✅ Task',
        ];
    }

    public static function log(int $leadId, string $type, string $description, ?int $userId = null, ?array $metadata = null): self
    {
        return static::create([
            'lead_id' => $leadId,
            'user_id' => $userId ?? auth()->id(),
            'type' => $type,
            'description' => $description,
            'metadata' => $metadata,
        ]);
    }

    public function scopePending($query)
    {
        return $query->where('is_completed', false)
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '>=', now());
    }

    public function scopeOverdue($query)
    {
        return $query->where('is_completed', false)
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<', now());
    }
}
