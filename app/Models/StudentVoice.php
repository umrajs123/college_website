<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StudentVoice extends Model
{
    protected $fillable = [
        'name',
        'program',
        'quote',
        'image_path',
        'image_alt',
        'highlights',
        'accent',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'highlights' => 'array',
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
            return asset('images/scps-logo.png');
        }

        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return asset('storage/'.$this->image_path);
    }
}
