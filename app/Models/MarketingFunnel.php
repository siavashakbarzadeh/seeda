<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingFunnel extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'file_path',
        'is_locked',
        'conversions'
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'conversions' => 'integer',
    ];

    public static function getTypeOptions(): array
    {
        return [
            'case_study' => '📄 Case Study',
            'price_guide' => '💶 Price Guide',
            'whitepaper' => '📘 Whitepaper',
            'checklist' => '✅ Checklist',
            'ebook' => '📚 E-Book',
        ];
    }

    public function incrementConversions(): void
    {
        $this->increment('conversions');
    }
}
