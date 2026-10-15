<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nursing_page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_type', 24)->default('content');
            $table->string('eyebrow', 120)->nullable();
            $table->string('title', 180);
            $table->text('body');
            $table->string('icon_label', 24)->nullable();
            $table->string('image_url', 1000)->nullable();
            $table->string('button_label', 80)->nullable();
            $table->string('button_url', 1000)->nullable();
            $table->string('secondary_button_label', 80)->nullable();
            $table->string('secondary_button_url', 1000)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('nursing_page_sections')->insert([
            [
                'section_type' => 'hero',
                'eyebrow' => 'School of Nursing',
                'title' => 'Care begins with a calling.',
                'body' => 'Discover nursing education at SCPS: a place to build knowledge, strengthen practical skills, and grow into a compassionate, confident caregiver.',
                'icon_label' => 'RN',
                'image_url' => null,
                'button_label' => 'Explore Admissions',
                'button_url' => null,
                'secondary_button_label' => 'Discover Our College',
                'secondary_button_url' => '#nursing-college',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_type' => 'content',
                'eyebrow' => 'About our college',
                'title' => 'A thoughtful start to a meaningful career',
                'body' => "The Nursing College at SCPS is dedicated to helping future nurses develop a strong foundation in care, communication, and professional responsibility.\n\nOur learning approach brings nursing knowledge together with practical preparation, so students can keep the person behind every patient at the heart of their work.",
                'icon_label' => '01',
                'image_url' => null,
                'button_label' => null,
                'button_url' => null,
                'secondary_button_label' => null,
                'secondary_button_url' => null,
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_type' => 'feature',
                'eyebrow' => 'Learning approach',
                'title' => 'Knowledge with compassion',
                'body' => 'Build a foundation in nursing concepts while developing the empathy, respect, and clear communication that excellent care calls for.',
                'icon_label' => '♡',
                'image_url' => null,
                'button_label' => null,
                'button_url' => null,
                'secondary_button_label' => null,
                'secondary_button_url' => null,
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_type' => 'feature',
                'eyebrow' => 'Practical preparation',
                'title' => 'Learn by doing',
                'body' => 'Connect classroom learning with practical skill development and a thoughtful, safety-conscious approach to patient care.',
                'icon_label' => '✚',
                'image_url' => null,
                'button_label' => null,
                'button_url' => null,
                'secondary_button_label' => null,
                'secondary_button_url' => null,
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_type' => 'feature',
                'eyebrow' => 'Professional growth',
                'title' => 'Ready to make a difference',
                'body' => 'Grow the confidence, teamwork, and lifelong-learning mindset to take your next steps in the nursing profession.',
                'icon_label' => '↗',
                'image_url' => null,
                'button_label' => null,
                'button_url' => null,
                'secondary_button_label' => null,
                'secondary_button_url' => null,
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_type' => 'cta',
                'eyebrow' => 'Begin your journey',
                'title' => 'Make care your calling.',
                'body' => 'Take the next step and learn more about joining the SCPS community.',
                'icon_label' => null,
                'image_url' => null,
                'button_label' => 'Talk to Admissions',
                'button_url' => null,
                'secondary_button_label' => null,
                'secondary_button_url' => null,
                'sort_order' => 6,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('nursing_page_sections');
    }
};
