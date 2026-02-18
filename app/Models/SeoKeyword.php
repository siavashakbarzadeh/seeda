<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoKeyword extends Model
{
    protected $fillable = [
        'keyword',
        'target_page',
        'current_position',
        'previous_position',
        'best_position',
        'search_volume',
        'difficulty',
        'cpc',
        'status',
        'campaign_id',
        'last_checked_at',
    ];

    protected $casts = [
        'difficulty' => 'decimal:2',
        'cpc' => 'decimal:2',
        'last_checked_at' => 'datetime',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function getPositionChangeAttribute(): int
    {
        if (!$this->previous_position || !$this->current_position)
            return 0;
        return $this->previous_position - $this->current_position; // positive = improved
    }

    public function getPositionTrendAttribute(): string
    {
        $change = $this->position_change;
        if ($change > 0)
            return '↑' . $change;
        if ($change < 0)
            return '↓' . abs($change);
        return '—';
    }

    public function getDifficultyLabelAttribute(): string
    {
        if (!$this->difficulty)
            return '—';
        return match (true) {
            $this->difficulty >= 80 => '🔴 Very Hard',
            $this->difficulty >= 60 => '🟠 Hard',
            $this->difficulty >= 40 => '🟡 Medium',
            $this->difficulty >= 20 => '🟢 Easy',
            default => '🟢 Very Easy',
        };
    }

    public function scopeTracking($query)
    {
        return $query->where('status', 'tracking');
    }

    public function scopeTopRanking($query, int $within = 10)
    {
        return $query->whereNotNull('current_position')
            ->where('current_position', '<=', $within);
    }
}
