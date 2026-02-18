<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialMediaPost extends Model
{
    protected $fillable = [
        'title',
        'content',
        'platform',
        'status',
        'media_url',
        'post_url',
        'scheduled_at',
        'published_at',
        'likes',
        'comments',
        'shares',
        'impressions',
        'clicks',
        'campaign_id',
        'created_by',
        'hashtags',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
        'hashtags' => 'array',
    ];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function getPlatformOptions(): array
    {
        return [
            'instagram' => '📸 Instagram',
            'facebook' => '📘 Facebook',
            'linkedin' => '💼 LinkedIn',
            'twitter' => '🐦 Twitter / X',
            'tiktok' => '🎵 TikTok',
            'youtube' => '🎬 YouTube',
            'pinterest' => '📌 Pinterest',
        ];
    }

    public function getEngagementRateAttribute(): float
    {
        if ($this->impressions <= 0)
            return 0;
        $engagement = $this->likes + $this->comments + $this->shares;
        return round(($engagement / $this->impressions) * 100, 2);
    }

    public function getTotalEngagementAttribute(): int
    {
        return $this->likes + $this->comments + $this->shares;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month);
    }
}
