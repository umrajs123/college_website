<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NursingPageSection extends Model
{
    protected $fillable = [
        'section_type',
        'eyebrow',
        'title',
        'body',
        'icon_label',
        'image_url',
        'button_label',
        'button_url',
        'secondary_button_label',
        'secondary_button_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function imageUrl(?string $fallback = null): ?string
    {
        if (! $this->image_url) {
            return $fallback;
        }

        if (str_starts_with($this->image_url, 'http://') || str_starts_with($this->image_url, 'https://')) {
            return $this->image_url;
        }

        return asset('storage/'.$this->image_url);
    }
}
