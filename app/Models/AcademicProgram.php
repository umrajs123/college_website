<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AcademicProgram extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'icon_label',
        'description',
        'duration',
        'eligibility',
        'overview',
        'learning_focus',
        'career_scope',
        'accent',
        'link_url',
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

    public function publicUrl(): string
    {
        return $this->link_url ?: route('programs.show', $this->slug);
    }
}
