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
            // Composite index for homepage and main listings: active + featured + created_at
            $table->index(['is_active', 'is_featured', 'created_at'], 'idx_jobs_active_featured_created');
            
            // Composite index for work_type filters (onsite/remote/hybrid): active + work_type + is_featured + created_at
            $table->index(['is_active', 'work_type', 'is_featured', 'created_at'], 'idx_jobs_active_worktype_feat');
            
            // Composite index for job type filters (internship/full-time): active + type + is_featured + created_at
            $table->index(['is_active', 'type', 'is_featured', 'created_at'], 'idx_jobs_active_type_feat');
            
            // Composite index for category lookups: active + category_id + created_at
            $table->index(['is_active', 'category_id', 'created_at'], 'idx_jobs_active_cat_created');
            
            // Composite index for company lookups: active + company_id + created_at
            $table->index(['is_active', 'company_id', 'created_at'], 'idx_jobs_active_comp_created');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->index(['is_active', 'type'], 'idx_companies_active_type');
            $table->index(['is_active', 'name'], 'idx_companies_active_name');
        });

        Schema::table('job_categories', function (Blueprint $table) {
            $table->index(['is_active', 'name'], 'idx_categories_active_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropIndex('idx_jobs_active_featured_created');
            $table->dropIndex('idx_jobs_active_worktype_feat');
            $table->dropIndex('idx_jobs_active_type_feat');
            $table->dropIndex('idx_jobs_active_cat_created');
            $table->dropIndex('idx_jobs_active_comp_created');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropIndex('idx_companies_active_type');
            $table->dropIndex('idx_companies_active_name');
        });

        Schema::table('job_categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_active_name');
        });
    }
};
