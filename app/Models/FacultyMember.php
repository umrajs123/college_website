<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'slug',
    'designation',
    'department',
    'image_path',
    'accent',
    'summary',
    'bio',
    'education',
    'experience',
    'specialties',
    'courses',
    'email',
    'office',
    'sort_order',
    'is_active',
])]
class FacultyMember extends Model
{
    protected function casts(): array
    {
        return [
            'specialties' => 'array',
            'courses' => 'array',
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
