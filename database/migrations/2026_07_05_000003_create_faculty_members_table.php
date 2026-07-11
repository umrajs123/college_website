<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('designation');
            $table->string('department');
            $table->string('image_path')->nullable();
            $table->string('accent')->default('sky');
            $table->text('summary');
            $table->longText('bio');
            $table->string('education')->nullable();
            $table->string('experience')->nullable();
            $table->json('specialties')->nullable();
            $table->json('courses')->nullable();
            $table->string('email')->nullable();
            $table->string('office')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty_members');
    }
};
