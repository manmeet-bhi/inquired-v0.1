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
            $columnsToDrop = [];

            if (Schema::hasColumn('testimonials', 'email')) {
                $columnsToDrop[] = 'email';
            }

            if (Schema::hasColumn('testimonials', 'is_approved')) {
                $columnsToDrop[] = 'is_approved';
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            if (!Schema::hasColumn('testimonials', 'email')) {
                $table->string('email')->nullable()->after('name');
            }

            if (!Schema::hasColumn('testimonials', 'is_approved')) {
                $table->boolean('is_approved')->default(true)->after('message');
            }
        });
    }
};
