<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'icon',
        'description',
        'features',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => \Illuminate\Support\Str::slug($value),
        );
    }
}
