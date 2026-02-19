<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectOpportunity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'client_name',
        'client_email',
        'source',
        'source_url',
        'budget_min',
        'budget_max',
        'currency',
        'budget_type',
        'technologies',
        'status',
        'priority',
        'estimated_hours',
        'deadline',
        'notes',
        'assigned_to',
        'applied_at',
        'response_at',
    ];

    protected $casts = [
        'technologies' => 'array',
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'estimated_hours' => 'integer',
        'deadline' => 'date',
        'applied_at' => 'datetime',
        'response_at' => 'datetime',
    ];

    // ── Relationships ──

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // ── Status Options ──

    public static function getStatusOptions(): array
    {
        return [
            'found' => '🔍 Found',
            'applied' => '📨 Applied',
            'interviewing' => '🎤 Interviewing',
            'proposal_sent' => '📄 Proposal Sent',
            'won' => '🏆 Won',
            'lost' => '❌ Lost',
            'passed' => '⏭️ Passed',
        ];
    }

    public static function getSourceOptions(): array
    {
        return [
            'upwork' => '🟢 Upwork',
            'freelancer' => '🔵 Freelancer',
            'fiverr' => '🟩 Fiverr',
            'toptal' => '🔷 Toptal',
            'linkedin' => '🔗 LinkedIn',
            'github' => '🐙 GitHub',
            'referral' => '🤝 Referral',
            'direct' => '📧 Direct Contact',
            'stackoverflow' => '📚 Stack Overflow Jobs',
            'angellist' => '😇 AngelList',
            'clutch' => '⭐ Clutch',
            'other' => '📌 Other',
        ];
    }

    public static function getPriorityOptions(): array
    {
        return [
            'low' => '🟢 Low',
            'medium' => '🟡 Medium',
            'high' => '🟠 High',
            'urgent' => '🔴 Urgent',
        ];
    }

    public static function getBudgetTypeOptions(): array
    {
        return [
            'fixed' => '💰 Fixed Price',
            'hourly' => '⏱️ Hourly',
            'monthly' => '📅 Monthly Retainer',
            'unknown' => '❓ Unknown',
        ];
    }

    public static function getTechOptions(): array
    {
        return [
            'laravel' => 'Laravel',
            'php' => 'PHP',
            'react' => 'React',
            'nextjs' => 'Next.js',
            'vue' => 'Vue.js',
            'nodejs' => 'Node.js',
            'python' => 'Python',
            'django' => 'Django',
            'wordpress' => 'WordPress',
            'shopify' => 'Shopify',
            'flutter' => 'Flutter',
            'react_native' => 'React Native',
            'swift' => 'Swift / iOS',
            'kotlin' => 'Kotlin / Android',
            'typescript' => 'TypeScript',
            'tailwind' => 'Tailwind CSS',
            'docker' => 'Docker',
            'aws' => 'AWS',
            'gcp' => 'Google Cloud',
            'mysql' => 'MySQL',
            'postgresql' => 'PostgreSQL',
            'mongodb' => 'MongoDB',
            'graphql' => 'GraphQL',
            'api' => 'REST API',
        ];
    }

    // ── Scopes ──

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['won', 'lost', 'passed']);
    }

    public function scopeWon($query)
    {
        return $query->where('status', 'won');
    }

    // ── Accessors ──

    public function getBudgetRangeAttribute(): string
    {
        if (!$this->budget_min && !$this->budget_max)
            return '—';
        if ($this->budget_min && $this->budget_max) {
            return "€" . number_format($this->budget_min, 0) . " – €" . number_format($this->budget_max, 0);
        }
        if ($this->budget_min)
            return "€" . number_format($this->budget_min, 0) . "+";
        return "Up to €" . number_format($this->budget_max, 0);
    }

    public function getDaysSinceFoundAttribute(): int
    {
        return $this->created_at->diffInDays(now());
    }
}
