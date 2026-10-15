<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $icons = [
        'Knowledge with compassion' => ['from' => '♡', 'to' => 'heart'],
        'Learn by doing' => ['from' => '✚', 'to' => 'stethoscope'],
        'Ready to make a difference' => ['from' => '↗', 'to' => 'spark'],
        'Communication builds trust' => ['from' => '♡', 'to' => 'people'],
        'Safety lives in the details' => ['from' => '✚', 'to' => 'shield'],
        'Stronger together' => ['from' => '↗', 'to' => 'pulse'],
    ];

    public function up(): void
    {
        foreach ($this->icons as $title => $icon) {
            DB::table('nursing_page_sections')
                ->where('section_type', 'feature')
                ->where('title', $title)
                ->where('icon_label', $icon['from'])
                ->update(['icon_label' => $icon['to']]);
        }
    }

    public function down(): void
    {
        foreach ($this->icons as $title => $icon) {
            DB::table('nursing_page_sections')
                ->where('section_type', 'feature')
                ->where('title', $title)
                ->where('icon_label', $icon['to'])
                ->update(['icon_label' => $icon['from']]);
        }
    }
};
