<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('academic_programs', function (Blueprint $table) {
            $table->string('duration', 120)->nullable()->after('description');
            $table->string('eligibility', 220)->nullable()->after('duration');
            $table->text('overview')->nullable()->after('eligibility');
            $table->text('learning_focus')->nullable()->after('overview');
            $table->text('career_scope')->nullable()->after('learning_focus');
        });
    }

    public function down(): void
    {
        Schema::table('academic_programs', function (Blueprint $table) {
            $table->dropColumn([
                'duration',
                'eligibility',
                'overview',
                'learning_focus',
                'career_scope',
            ]);
        });
    }
};
