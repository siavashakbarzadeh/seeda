<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutomationRule extends Model
{
    protected $fillable = [
        'name',
        'description',
        'trigger',
        'conditions',
        'actions',
        'is_active',
        'executions_count',
        'last_executed_at',
    ];

    protected $casts = [
        'conditions' => 'array',
        'actions' => 'array',
        'is_active' => 'boolean',
        'executions_count' => 'integer',
        'last_executed_at' => 'datetime',
    ];

    // ── Trigger Options ──

    public static function getTriggerOptions(): array
    {
        return [
            'lead_created' => '🆕 Lead Created',
            'score_reached' => '🎯 Score Threshold Reached',
            'status_changed' => '🔄 Lead Status Changed',
            'form_submitted' => '📝 Contact Form Submitted',
            'interaction_recorded' => '📊 Behavioral Interaction Recorded',
            'campaign_started' => '▶️ Campaign Started',
        ];
    }

    public static function getActionTypeOptions(): array
    {
        return [
            'send_email' => '✉️ Send Email Template',
            'assign_user' => '👤 Assign to User',
            'change_status' => '🔄 Change Lead Status',
            'add_score' => '🎯 Add Lead Score',
            'create_activity' => '📝 Create Activity Note',
            'add_to_email_list' => '📋 Add to Email List',
            'notify_admin' => '🔔 Notify Admin',
        ];
    }

    // ── Scopes ──

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForTrigger($query, string $trigger)
    {
        return $query->where('trigger', $trigger)->active();
    }

    // ── Methods ──

    public function incrementExecutions(): void
    {
        $this->update([
            'executions_count' => $this->executions_count + 1,
            'last_executed_at' => now(),
        ]);
    }

    public function matchesConditions(array $context): bool
    {
        if (empty($this->conditions)) {
            return true;
        }

        foreach ($this->conditions as $key => $value) {
            if (!isset($context[$key]))
                return false;
            if ($key === 'score_min' && $context[$key] < $value)
                return false;
            if ($key === 'score_max' && $context[$key] > $value)
                return false;
            if ($key !== 'score_min' && $key !== 'score_max' && $context[$key] !== $value)
                return false;
        }

        return true;
    }
}
