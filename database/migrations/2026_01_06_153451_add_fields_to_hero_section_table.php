<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_section', function (Blueprint $table) {
            $table->string('sub_title')->nullable()->after('id');
            $table->string('title')->nullable()->after('sub_title');
            $table->string('bg_image')->nullable()->after('title');
            $table->string('hero_image')->nullable()->after('bg_image');
            $table->boolean('is_active')->default(true)->after('hero_image');
        });
    }

    public function down(): void
    {
        Schema::table('hero_section', function (Blueprint $table) {
            $table->dropColumn([
                'sub_title',
                'title',
                'bg_image',
                'hero_image',
                'is_active'
            ]);
        });
    }
};
