<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class CampusLifeSection extends Model
{
    protected $fillable = [
        'eyebrow',
        'heading',
        'body',
        'image_path',
        'image_alt',
        'image_badge',
        'image_heading',
        'cards',
        'highlights',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'cards' => 'array',
            'highlights' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public static function current(): ?self
    {
        if (Schema::hasTable('campus_life_sections')) {
            return static::query()->where('is_active', true)->first() ?? new static(static::defaults());
        }

        return new static(static::defaults());
    }

    public static function defaults(): array
    {
        return [
            'eyebrow' => 'Campus Life',
            'heading' => 'A focused campus culture built around learning, confidence, and care.',
            'body' => 'Life at SCPS balances disciplined academic routines with peer support, guided lab practice, events, seminars, and spaces where students feel connected to their future profession.',
            'image_path' => 'https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=1200&q=85',
            'image_alt' => 'Students walking on campus',
            'image_badge' => 'Student Community',
            'image_heading' => 'Study groups, mentoring circles, and everyday support that keeps students moving forward.',
            'cards' => [
                ['title' => 'Learning Beyond Class', 'text' => 'Workshops, guest talks, case discussions, and guided lab sessions help students connect theory with real pharmacy practice.', 'accent' => 'sky'],
                ['title' => 'Health & Professional Values', 'text' => 'Campus activities encourage responsibility, communication, ethics, and the confidence students need in healthcare environments.', 'accent' => 'teal'],
                ['title' => 'Events, Clubs & Seminars', 'text' => 'Academic events, student-led activities, and professional seminars create a lively rhythm without distracting from serious study.', 'accent' => 'indigo'],
            ],
            'highlights' => [
                ['label' => 'Daily Rhythm', 'value' => 'Structured', 'accent' => 'sky'],
                ['label' => 'Student Support', 'value' => 'Accessible', 'accent' => 'teal'],
                ['label' => 'Campus Energy', 'value' => 'Professional', 'accent' => 'indigo'],
            ],
            'is_active' => true,
        ];
    }

    public function imageUrl(): string
    {
        if (! $this->image_path) {
            return static::defaults()['image_path'];
        }

        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return asset('storage/'.$this->image_path);
    }
}
