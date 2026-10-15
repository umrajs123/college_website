<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('nursing_page_sections')
            ->where('title', 'Testing Another Section')
            ->where('body', 'Money is the root of all evil!')
            ->update(['is_active' => false]);
    }

    public function down(): void
    {
        DB::table('nursing_page_sections')
            ->where('title', 'Testing Another Section')
            ->where('body', 'Money is the root of all evil!')
            ->where('is_active', false)
            ->update(['is_active' => true]);
    }
};
