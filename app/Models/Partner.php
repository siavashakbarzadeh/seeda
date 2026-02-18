<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'email',
        'code',
        'commission_rate',
        'type',
        'status',
        'balance',
        'total_earned',
        'settings'
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'balance' => 'decimal:2',
        'total_earned' => 'decimal:2',
        'settings' => 'array',
    ];

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(PayoutLog::class);
    }

    public static function generateCode(string $name): string
    {
        $slug = Str::slug($name);
        $code = $slug;
        $counter = 1;

        while (static::where('code', $code)->exists()) {
            $code = $slug . '-' . $counter;
            $counter++;
        }

        return $code;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
