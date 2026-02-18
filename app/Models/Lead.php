<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'website',
        'industry',
        'company_size',
        'source',
        'status',
        'estimated_value',
        'score',
        'priority',
        'notes',
        'assigned_to',
        'campaign_id',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'last_contacted_at',
        'converted_at',
        'client_id',
    ];

    protected $casts = [
        'estimated_value' => 'decimal:2',
        'last_contacted_at' => 'datetime',
        'converted_at' => 'datetime',
    ];

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class)->latest();
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

    public static function getCompanySizeOptions(): array
    {
        return [
            '1-10' => '1-10 employees',
            '11-50' => '11-50 employees',
            '51-200' => '51-200 employees',
            '201-500' => '201-500 employees',
            '500+' => '500+ employees',
        ];
    }

    public static function getIndustryOptions(): array
    {
        return [
            'technology' => 'Technology',
            'healthcare' => 'Healthcare',
            'finance' => 'Finance',
            'education' => 'Education',
            'ecommerce' => 'E-Commerce',
            'manufacturing' => 'Manufacturing',
            'real_estate' => 'Real Estate',
            'hospitality' => 'Hospitality',
            'legal' => 'Legal',
            'non_profit' => 'Non-Profit',
            'other' => 'Other',
        ];
    }

    /**
     * Auto-calculate lead score based on data completeness & engagement.
     */
    public function calculateScore(): int
    {
        $score = 0;

        // Data completeness
        if ($this->email)
            $score += 10;
        if ($this->phone)
            $score += 10;
        if ($this->company)
            $score += 10;
        if ($this->website)
            $score += 5;
        if ($this->industry)
            $score += 5;

        // Estimated value
        if ($this->estimated_value >= 10000)
            $score += 20;
        elseif ($this->estimated_value >= 5000)
            $score += 15;
        elseif ($this->estimated_value >= 1000)
            $score += 10;

        // Pipeline stage
        $stageScores = ['new' => 5, 'contacted' => 10, 'qualified' => 20, 'proposal' => 30, 'negotiation' => 40];
        $score += $stageScores[$this->status] ?? 0;

        // Engagement: has activities?
        $activityCount = $this->activities()->count();
        $score += min(20, $activityCount * 5);

        $this->update(['score' => $score]);
        return $score;
    }

    public static function getSourceOptions(): array
    {
        return [
            'website' => '🌐 Website',
            'referral' => '🤝 Referral',
            'google' => '🔍 Google',
            'social' => '📱 Social Media',
            'cold_call' => '📞 Cold Call',
            'event' => '🎪 Event',
            'linkedin' => '💼 LinkedIn',
            'email' => '📧 Email',
            'other' => '📋 Other',
        ];
    }

    public static function getStatusOptions(): array
    {
        return [
            'new' => '🆕 New',
            'contacted' => '📞 Contacted',
            'qualified' => '✅ Qualified',
            'proposal' => '📄 Proposal Sent',
            'negotiation' => '🤝 Negotiation',
            'won' => '🏆 Won',
            'lost' => '❌ Lost',
        ];
    }

    public function scopeOpen($query)
    {
        return $query->whereNotIn('status', ['won', 'lost']);
    }

    public function scopeWon($query)
    {
        return $query->where('status', 'won');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month);
    }

    public function convertToClient(): ?Client
    {
        if ($this->client_id)
            return $this->client;

        $client = Client::create([
            'name' => $this->company ?: $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $this->update([
            'status' => 'won',
            'converted_at' => now(),
            'client_id' => $client->id,
        ]);

        if ($this->campaign_id) {
            $this->campaign?->increment('conversions');
        }

        // Log the conversion
        LeadActivity::log($this->id, 'status_change', 'Lead converted to client: ' . $client->name);

        return $client;
    }

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    public function scopeHotLeads($query)
    {
        return $query->where('score', '>=', 50)->open();
    }
}
