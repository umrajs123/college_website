<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'slug',
    'category',
    'excerpt',
    'body',
    'image_path',
    'image_alt',
    'accent',
    'published_at',
    'sort_order',
    'is_active',
])]
class NewsPost extends Model
{
    protected function casts(): array
    {
        return [
            'published_at' => 'date',
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
            return 'https://images.unsplash.com/photo-1582560475093-ba66accbc424?auto=format&fit=crop&w=900&q=85';
        }

        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return asset('storage/'.$this->image_path);
    }
}
