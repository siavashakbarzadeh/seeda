<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadInteraction extends Model
{
    protected $fillable = [
        'session_id',
        'lead_id',
        'url',
        'action',
        'points',
        'meta'
    ];

    protected $casts = [
        'points' => 'integer',
        'meta' => 'array',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * Track a new interaction and update lead score.
     */
    public static function track(string $action, ?int $leadId = null, array $meta = []): self
    {
        $points = match ($action) {
            'view_pricing' => 20,
            'download_case_study' => 30,
            'view_services' => 10,
            'contact_form_start' => 5,
            'exit_intent_recovered' => 15,
            'newsletter_signup' => 25,
            'repeat_visit' => 10,
            default => 2,
        };

        $interaction = static::create([
            'session_id' => session()->getId() ?? 'anonymous',
            'lead_id' => $leadId,
            'url' => request()->fullUrl(),
            'action' => $action,
            'points' => $points,
            'meta' => $meta,
        ]);

        if ($leadId) {
            $lead = Lead::find($leadId);
            if ($lead) {
                $lead->increment('score', $points);

                // Trigger auto-actions if score crosses threshold
                if ($lead->score >= 80 && $lead->priority !== 'urgent') {
                    $lead->update(['priority' => 'urgent']);
                    // Notify sales team?
                } elseif ($lead->score >= 50 && $lead->priority === 'medium') {
                    $lead->update(['priority' => 'high']);
                }
            }
        }

        return $interaction;
    }
}
