<?php

namespace App\Providers;

use App\Models\AcademicProgram;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $request = request();
            $settings = $request->attributes->get('site_settings');

            if (! $settings instanceof SiteSetting) {
                $settings = SiteSetting::current();
                $request->attributes->set('site_settings', $settings);
            }

            $view->with('siteSettings', $settings);
        });

        View::composer(['partials.admissions-popup', 'admin.admissions-popup.edit'], function ($view) {
            $programs = Schema::hasTable('academic_programs')
                ? AcademicProgram::active()
                    ->orderBy('sort_order')
                    ->orderBy('title')
                    ->get(['title', 'slug', 'icon_label', 'link_url'])
                : collect();

            $view->with('admissionsPopupPrograms', $programs);
        });
    }
}
