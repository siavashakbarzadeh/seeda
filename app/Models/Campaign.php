<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'type',
        'status',
        'budget',
        'spent',
        'start_date',
        'end_date',
        'description',
        'target_url',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'impressions',
        'clicks',
        'conversions',
        'revenue_generated',
        'tags',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'spent' => 'decimal:2',
        'revenue_generated' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'tags' => 'array',
    ];

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public static function getTypeOptions(): array
    {
        return [
            'google_ads' => '🔍 Google Ads',
            'facebook' => '📘 Facebook Ads',
            'instagram' => '📸 Instagram',
            'linkedin' => '💼 LinkedIn',
            'email' => '📧 Email Campaign',
            'seo' => '🔎 SEO',
            'referral' => '🤝 Referral Program',
            'event' => '🎪 Event / Webinar',
            'content' => '📝 Content Marketing',
            'other' => '📋 Other',
        ];
    }

    // Performance metrics
    public function getCtrAttribute(): float
    {
        if ($this->impressions <= 0)
            return 0;
        return round(($this->clicks / $this->impressions) * 100, 2);
    }

    public function getConversionRateAttribute(): float
    {
        if ($this->clicks <= 0)
            return 0;
        return round(($this->conversions / $this->clicks) * 100, 2);
    }

    public function getCostPerClickAttribute(): float
    {
        if ($this->clicks <= 0)
            return 0;
        return round($this->spent / $this->clicks, 2);
    }

    public function getCostPerConversionAttribute(): float
    {
        if ($this->conversions <= 0)
            return 0;
        return round($this->spent / $this->conversions, 2);
    }

    public function getRoiAttribute(): float
    {
        if ($this->spent <= 0)
            return 0;
        return round((($this->revenue_generated - $this->spent) / $this->spent) * 100, 1);
    }

    public function getBudgetUsedPercentAttribute(): int
    {
        if (!$this->budget || $this->budget <= 0)
            return 0;
        return min(100, (int) round(($this->spent / $this->budget) * 100));
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
