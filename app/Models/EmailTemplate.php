<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailTemplate extends Model
{
    protected $fillable = ['name', 'subject', 'content', 'category', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function campaigns(): HasMany
    {
        return $this->hasMany(EmailCampaign::class);
    }

    /**
     * Replace placeholders with actual data.
     */
    public function render(array $data): string
    {
        $placeholders = [
            '{{name}}' => $data['name'] ?? '',
            '{{email}}' => $data['email'] ?? '',
            '{{company}}' => $data['company'] ?? 'your company',
            '{{unsubscribe_url}}' => '#',
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $this->content);
    }

    public static function getCategoryOptions(): array
    {
        return [
            'marketing' => '📢 Marketing',
            'sales' => '💰 Sales / Follow-up',
            'support' => '🛠️ Support',
            'transactional' => '📧 Transactional',
        ];
    }
}
