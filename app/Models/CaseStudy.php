<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'tags',
        'excerpt',
        'challenge',
        'solution',
        'results',
        'color',
        'thumbnail',
        'client_name',
        'client_logo',
        'live_url',
        'duration',
        'technologies',
        'testimonial_text',
        'testimonial_author',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'tags' => 'array',
        'results' => 'array',
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function getCategoryOptions(): array
    {
        return [
            'Web App' => '🌐 Web App',
            'Mobile' => '📱 Mobile',
            'E-Commerce' => '🛒 E-Commerce',
            'SaaS' => '☁️ SaaS',
            'AI / ML' => '🤖 AI / ML',
            'Data Science' => '📊 Data Science',
            'FinTech' => '💳 FinTech',
            'Healthcare' => '🏥 Healthcare',
            'Logistics' => '🚛 Logistics',
            'Mobile / PWA' => '📲 Mobile / PWA',
            'Enterprise' => '🏢 Enterprise',
            'Other' => '📌 Other',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->thumbnail)
            return null;
        return asset('storage/' . $this->thumbnail);
    }

    public function getClientLogoUrlAttribute(): ?string
    {
        if (!$this->client_logo)
            return null;
        return asset('storage/' . $this->client_logo);
    }
}
