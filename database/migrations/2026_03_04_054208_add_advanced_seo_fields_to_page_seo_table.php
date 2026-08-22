<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('page_seo', function (Blueprint $table) {
            $table->string('twitter_title', 60)->nullable()->after('og_image');
            $table->string('twitter_description', 160)->nullable()->after('twitter_title');
            $table->string('twitter_image')->nullable()->after('twitter_description');
            $table->text('schema_json')->nullable()->after('twitter_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_seo', function (Blueprint $table) {
            $table->dropColumn(['twitter_title', 'twitter_description', 'twitter_image', 'schema_json']);
        });
    }
};
