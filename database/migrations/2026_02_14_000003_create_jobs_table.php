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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('job_categories')->nullOnDelete();
            $table->string('location');
            $table->string('experience')->nullable();
            $table->enum('type', ['full-time', 'part-time', 'contract', 'internship', 'freelance']);
            $table->enum('work_type', ['onsite', 'remote', 'hybrid']);
            $table->enum('level', ['entry', 'junior', 'mid', 'senior', 'lead', 'executive']);
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('salary_currency', 3)->default('USD')->nullable();
            $table->text('overview');
            $table->json('responsibilities');
            $table->json('requirements');
            $table->text('extra_details')->nullable();
            $table->json('benefits')->nullable();
            $table->json('skills')->nullable();
            $table->date('application_deadline')->nullable();
            $table->string('external_url', 500)->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('applications_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('admin_created_by')->nullable()->constrained('admin_users')->nullOnDelete();
            $table->string('application_url')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'is_featured']);
            $table->index(['type', 'work_type']);
            $table->index('location');
            $table->fullText(['title', 'overview']); // Fulltext search index
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
