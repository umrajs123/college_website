<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leadership_messages', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('message');
            $table->string('image_path')->nullable();
            $table->json('tags')->nullable();
            $table->string('accent')->default('sky');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leadership_messages');
    }
};
