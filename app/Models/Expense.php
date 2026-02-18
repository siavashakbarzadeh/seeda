<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'category',
        'description',
        'amount',
        'date',
        'receipt_path',
        'is_reimbursable',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
        'is_reimbursable' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public static function getCategoryOptions(): array
    {
        return [
            'software' => '💻 Software & Licenses',
            'hardware' => '🖥️ Hardware',
            'hosting' => '☁️ Hosting & Servers',
            'domain' => '🌐 Domains',
            'marketing' => '📢 Marketing & Ads',
            'travel' => '✈️ Travel',
            'office' => '🏢 Office Supplies',
            'subscription' => '🔄 Subscriptions',
            'freelancer' => '👤 Freelancer/Contractor',
            'training' => '📚 Training & Education',
            'insurance' => '🛡️ Insurance',
            'utilities' => '💡 Utilities',
            'other' => '📦 Other',
        ];
    }

    // ── Scopes ──

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereYear('date', now()->year)->whereMonth('date', now()->month);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('date', now()->year);
    }
}
