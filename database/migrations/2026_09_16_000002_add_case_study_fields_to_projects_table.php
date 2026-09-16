<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('client_name')->nullable()->after('summary');
            $table->string('industry')->nullable()->after('client_name');
            $table->text('challenge')->nullable()->after('industry');
            $table->text('solution')->nullable()->after('challenge');
            $table->text('results')->nullable()->after('solution');
            $table->json('gallery')->nullable()->after('results');
            $table->text('testimonial_quote')->nullable()->after('gallery');
            $table->string('testimonial_author')->nullable()->after('testimonial_quote');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'client_name',
                'industry',
                'challenge',
                'solution',
                'results',
                'gallery',
                'testimonial_quote',
                'testimonial_author',
            ]);
        });
    }
};
