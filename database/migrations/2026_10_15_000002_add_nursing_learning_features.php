<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $features = [
        [
            'eyebrow' => 'The human connection',
            'title' => 'Communication builds trust',
            'body' => 'A calm introduction, attentive listening, and clear explanations can help people feel respected and informed. Practice communicating with empathy while protecting privacy and dignity.',
            'icon_label' => '♡',
            'sort_order' => 6,
        ],
        [
            'eyebrow' => 'A safety-first mindset',
            'title' => 'Safety lives in the details',
            'body' => 'Observation, infection prevention, accurate documentation, and thoughtful habits all contribute to safer care. Learn to notice the small details and speak up when something needs attention.',
            'icon_label' => '✚',
            'sort_order' => 7,
        ],
        [
            'eyebrow' => 'Care is collaborative',
            'title' => 'Stronger together',
            'body' => 'Nurses work alongside patients, families, and wider healthcare teams. Clear handovers, thoughtful questions, and respectful collaboration help support coordinated care.',
            'icon_label' => '↗',
            'sort_order' => 8,
        ],
    ];

    public function up(): void
    {
        $now = now();

        foreach ($this->features as $feature) {
            DB::table('nursing_page_sections')->insert([
                ...$feature,
                'section_type' => 'feature',
                'image_url' => null,
                'button_label' => null,
                'button_url' => null,
                'secondary_button_label' => null,
                'secondary_button_url' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('nursing_page_sections')
            ->where('section_type', 'feature')
            ->whereIn('title', array_column($this->features, 'title'))
            ->delete();
    }
};
