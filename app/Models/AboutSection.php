<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'eyebrow',
        'heading',
        'body',
        'image_path',
        'image_alt',
        'badge_value',
        'badge_label',
        'button_label',
        'button_url',
        'features',
        'accent',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function imageUrl(): string
    {
        if (! $this->image_path) {
            return 'https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&w=900&q=85';
        }

        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return asset('storage/'.$this->image_path);
    }
}
