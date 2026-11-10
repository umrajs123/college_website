<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('admissions_popup_is_active')->default(true);
            $table->string('admissions_popup_eyebrow')->default('Admissions Open');
            $table->string('admissions_popup_heading')->default('Your future in pharmacy starts here.');
            $table->text('admissions_popup_body')->nullable();
            $table->string('admissions_popup_button_label')->default('Apply Now');
            $table->string('admissions_popup_button_url')->nullable();
            $table->string('admissions_popup_image_path')->nullable();
        });

        DB::table('site_settings')
            ->whereNull('admissions_popup_body')
            ->update([
                'admissions_popup_body' => 'Build the knowledge, practical skills, and confidence to make a difference in healthcare. Take the next step with Swat College of Pharmaceutical Sciences.',
            ]);
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'admissions_popup_is_active',
                'admissions_popup_eyebrow',
                'admissions_popup_heading',
                'admissions_popup_body',
                'admissions_popup_button_label',
                'admissions_popup_button_url',
                'admissions_popup_image_path',
            ]);
        });
    }
};
