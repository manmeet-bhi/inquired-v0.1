<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicates = DB::table('page_seo')
            ->select('page_type', 'page_id', DB::raw('MAX(id) as keep_id'))
            ->whereNotNull('page_id')
            ->groupBy('page_type', 'page_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('page_seo')
                ->where('page_type', $duplicate->page_type)
                ->where('page_id', $duplicate->page_id)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }

        Schema::table('page_seo', function ($table) {
            $table->unique(['page_type', 'page_id'], 'page_seo_type_page_unique');
        });
    }

    public function down(): void
    {
        Schema::table('page_seo', function ($table) {
            $table->dropUnique('page_seo_type_page_unique');
        });
    }
};
