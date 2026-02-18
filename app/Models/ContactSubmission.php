<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactSubmission extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'source_page',
        'utm_source',
        'utm_medium',
        'status',
        'lead_id',
        'ip_address',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function convertToLead(): Lead
    {
        $lead = Lead::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => $this->company,
            'source' => 'website',
            'status' => 'new',
            'utm_source' => $this->utm_source,
            'utm_medium' => $this->utm_medium,
            'notes' => "From contact form: {$this->subject}\n\n{$this->message}",
        ]);

        $this->update([
            'status' => 'read',
            'lead_id' => $lead->id,
        ]);

        return $lead;
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'new');
    }
}
