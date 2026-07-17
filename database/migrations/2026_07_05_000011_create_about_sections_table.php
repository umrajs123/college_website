<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->default('About SCPS');
            $table->string('heading');
            $table->text('body')->nullable();
            $table->string('image_path', 700)->nullable();
            $table->string('image_alt')->nullable();
            $table->string('badge_value', 40)->nullable();
            $table->string('badge_label', 140)->nullable();
            $table->string('button_label', 80)->nullable();
            $table->string('button_url', 700)->nullable();
            $table->json('features')->nullable();
            $table->string('accent', 30)->default('sky');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
