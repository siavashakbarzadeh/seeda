<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ABTest extends Model
{
    protected $table = 'ab_tests';

    protected $fillable = [
        'campaign_id',
        'name',
        'description',
        'variant_a_label',
        'variant_b_label',
        'variant_a_views',
        'variant_b_views',
        'variant_a_conversions',
        'variant_b_conversions',
        'status',
        'winner',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'variant_a_views' => 'integer',
        'variant_b_views' => 'integer',
        'variant_a_conversions' => 'integer',
        'variant_b_conversions' => 'integer',
    ];

    // ── Relationships ──

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    // ── Accessors ──

    public function getVariantAConversionRateAttribute(): float
    {
        return $this->variant_a_views > 0
            ? round(($this->variant_a_conversions / $this->variant_a_views) * 100, 2)
            : 0;
    }

    public function getVariantBConversionRateAttribute(): float
    {
        return $this->variant_b_views > 0
            ? round(($this->variant_b_conversions / $this->variant_b_views) * 100, 2)
            : 0;
    }

    public function getConfidenceLevelAttribute(): string
    {
        $totalViews = $this->variant_a_views + $this->variant_b_views;
        if ($totalViews < 100)
            return 'Low';
        if ($totalViews < 500)
            return 'Medium';
        return 'High';
    }

    // ── Scopes ──

    public function scopeRunning($query)
    {
        return $query->where('status', 'running');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // ── Methods ──

    public function declareWinner(): void
    {
        $rateA = $this->variant_a_conversion_rate;
        $rateB = $this->variant_b_conversion_rate;

        $this->update([
            'status' => 'completed',
            'winner' => $rateA > $rateB ? 'a' : ($rateB > $rateA ? 'b' : null),
            'end_date' => now(),
        ]);
    }
}
