<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('page_seo', function (Blueprint $table) {
            $table->id();
            $table->string('page_type'); // 'job', 'category', 'company', 'static'
            $table->unsignedBigInteger('page_id')->nullable(); // ID of the related model
            $table->string('slug')->unique();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('noindex')->default(false);
            $table->boolean('nofollow')->default(false);
            $table->timestamps();
            
            $table->index(['page_type', 'page_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_seo');
    }
};