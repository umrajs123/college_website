<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_voices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('program')->nullable();
            $table->text('quote');
            $table->string('image_path', 700)->nullable();
            $table->string('image_alt')->nullable();
            $table->json('highlights')->nullable();
            $table->string('accent', 30)->default('sky');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_voices');
    }
};
