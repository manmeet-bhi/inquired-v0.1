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
        Schema::table('testimonials', function (Blueprint $table) {
            $table->index('created_at', 'idx_testimonials_created_at');
            $table->index('name', 'idx_testimonials_name');
            $table->index('role_company', 'idx_testimonials_role_company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex('idx_testimonials_created_at');
            $table->dropIndex('idx_testimonials_name');
            $table->dropIndex('idx_testimonials_role_company');
        });
    }
};
