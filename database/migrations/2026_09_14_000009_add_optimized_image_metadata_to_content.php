<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['projects', 'posts'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('image_original_path')->nullable();
                $table->json('image_variants')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['projects', 'posts'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['image_original_path', 'image_variants']);
            });
        }
    }
};
