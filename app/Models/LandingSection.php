<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class LandingSection extends Model
{
    use HasTranslations;

    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'content',
        'button_text',
        'button_link',
        'image',
        'extra',
        'is_active',
        'sort_order',
    ];

    public array $translatable = [
        'title',
        'subtitle',
        'content',
        'button_text',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'extra' => 'array',
    ];

    public static function getByKey(string $key): ?self
    {
        return static::where('key', $key)->where('is_active', true)->first();
    }
}
