<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EmailList extends Model
{
    protected $fillable = ['name', 'description', 'color'];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(NewsletterSubscriber::class, 'email_list_subscriber');
    }

    public function campaigns()
    {
        return $this->hasMany(EmailCampaign::class);
    }
}
