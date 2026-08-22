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
        Schema::table('jobs', function (Blueprint $table) {
            $table->longText('content')->after('overview')->nullable();
            
            $table->dropColumn([
                'overview',
                'responsibilities',
                'requirements',
                'extra_details',
                'benefits',
                'skills'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('content');
            
            $table->text('overview');
            $table->json('responsibilities');
            $table->json('requirements');
            $table->text('extra_details')->nullable();
            $table->json('benefits')->nullable();
            $table->json('skills')->nullable();
        });
    }
};
