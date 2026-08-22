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
        Schema::create('session_activities', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->text('url');
            $table->text('referrer')->nullable(); // Referrer for this specific page view
            $table->timestamp('created_at')->useCurrent();
            
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_activities');
    }
};
