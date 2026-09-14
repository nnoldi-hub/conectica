<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('file_path');
            $table->string('disk')->default('public');
            $table->string('alt_text')->nullable();
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size');
            $table->timestamps();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('summary');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('body');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });

        Schema::dropIfExists('media');
    }
};
