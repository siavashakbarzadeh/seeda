<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'client_id',
        'website_id',
        'ticket_number',
        'subject',
        'category',
        'tags',
        'description',
        'priority',
        'status',
        'assigned_to',
        'closed_at',
        'first_responded_at',
        'sla_hours',
        'satisfaction_rating',
        'satisfaction_comment',
        'source',
    ];

    protected $casts = [
        'closed_at' => 'datetime',
        'first_responded_at' => 'datetime',
        'tags' => 'array',
        'satisfaction_rating' => 'integer',
    ];

    // ── Relations ──

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class)->orderBy('created_at');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }

    // ── Helpers ──

    public static function generateNumber(): string
    {
        $last = static::max('id') ?? 0;
        return 'TKT-' . str_pad($last + 1, 5, '0', STR_PAD_LEFT);
    }

    public function markFirstResponse(): void
    {
        if (!$this->first_responded_at) {
            $this->update(['first_responded_at' => now()]);
        }
    }

    public function getResponseTimeAttribute(): ?string
    {
        if (!$this->first_responded_at)
            return null;
        $diff = $this->created_at->diff($this->first_responded_at);
        if ($diff->days > 0)
            return $diff->days . 'd ' . $diff->h . 'h';
        if ($diff->h > 0)
            return $diff->h . 'h ' . $diff->i . 'm';
        return $diff->i . 'm';
    }

    public function isSlaBreached(): bool
    {
        if (!$this->sla_hours)
            return false;
        if ($this->first_responded_at) {
            return $this->created_at->diffInHours($this->first_responded_at) > $this->sla_hours;
        }
        return $this->created_at->diffInHours(now()) > $this->sla_hours;
    }

    public function getSlaStatusAttribute(): string
    {
        if (!$this->sla_hours)
            return 'no_sla';
        if ($this->first_responded_at) {
            return $this->isSlaBreached() ? 'breached' : 'met';
        }
        return $this->isSlaBreached() ? 'overdue' : 'active';
    }

    // ── Scopes ──

    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['open', 'in_progress', 'waiting']);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeUnrated($query)
    {
        return $query->whereIn('status', ['resolved', 'closed'])
            ->whereNull('satisfaction_rating');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
