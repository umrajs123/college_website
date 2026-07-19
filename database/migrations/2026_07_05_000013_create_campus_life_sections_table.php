<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campus_life_sections', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->default('Campus Life');
            $table->string('heading');
            $table->text('body')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_badge')->nullable();
            $table->string('image_heading')->nullable();
            $table->json('cards')->nullable();
            $table->json('highlights')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campus_life_sections');
    }
};
