<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'body',
        'status',
        'scheduled_at',
        'sent_at',
        'recipients_count',
        'opened_count',
        'clicked_count',
        'bounced_count',
        'unsubscribed_count',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function getOpenRateAttribute(): float
    {
        if ($this->recipients_count <= 0)
            return 0;
        return round(($this->opened_count / $this->recipients_count) * 100, 1);
    }

    public function getClickRateAttribute(): float
    {
        if ($this->recipients_count <= 0)
            return 0;
        return round(($this->clicked_count / $this->recipients_count) * 100, 1);
    }

    public function getBounceRateAttribute(): float
    {
        if ($this->recipients_count <= 0)
            return 0;
        return round(($this->bounced_count / $this->recipients_count) * 100, 1);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}
