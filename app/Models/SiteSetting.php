<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

#[Fillable([
    'site_name',
    'site_tagline',
    'site_description',
    'logo_path',
    'favicon_path',
    'phone',
    'email',
    'address',
    'admissions_url',
    'facebook_url',
    'linkedin_url',
    'youtube_url',
    'privacy_url',
])]
class SiteSetting extends Model
{
    protected $guarded = [];

    public static function current(): self
    {
        if (Schema::hasTable('site_settings')) {
            return static::query()->first() ?? new static(static::defaults());
        }

        return new static(static::defaults());
    }

    public static function defaults(): array
    {
        return [
            'site_name' => 'Swat College',
            'site_tagline' => 'of Pharmaceutical Sciences',
            'site_description' => 'Academic pharmacy education in Swat with a focus on professional competence, laboratory skill, and healthcare service.',
            'logo_path' => 'images/scps-logo.png',
            'favicon_path' => 'images/scps-logo.png',
            'phone' => '+92 946 123456',
            'email' => 'info@scps.edu.pk',
            'address' => 'College Road, Swat, Khyber Pakhtunkhwa, Pakistan',
            'admissions_url' => 'https://scps.digitalcampuspro.com/admin/login',
            'facebook_url' => null,
            'linkedin_url' => null,
            'youtube_url' => null,
            'privacy_url' => '#',
        ];
    }

    public function logoUrl(): string
    {
        return $this->assetUrl($this->logo_path ?: static::defaults()['logo_path']);
    }

    public function faviconUrl(): string
    {
        return $this->assetUrl($this->favicon_path ?: $this->logo_path ?: static::defaults()['favicon_path']);
    }

    public function phoneHref(): ?string
    {
        if (! $this->phone) {
            return null;
        }

        return 'tel:'.preg_replace('/[^0-9+]/', '', $this->phone);
    }

    public function emailHref(): ?string
    {
        return $this->email ? 'mailto:'.$this->email : null;
    }

    private function assetUrl(?string $path): string
    {
        if (! $path) {
            return asset('images/scps-logo.png');
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, 'site-settings/')) {
            return asset('storage/'.$path);
        }

        return asset($path);
    }
}
