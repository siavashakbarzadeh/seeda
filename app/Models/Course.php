<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Course extends Model
{
    use HasTranslations;

    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'description',
        'curriculum',
        'career_info',
        'price',
        'currency',
        'installment_info',
        'duration',
        'level',
        'format',
        'location',
        'image',
        'link',
        'is_active',
        'is_featured',
        'sort_order',
        'starts_at',
    ];

    public array $translatable = [
        'title',
        'subtitle',
        'description',
        'curriculum',
        'career_info',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'starts_at' => 'datetime',
    ];
}
