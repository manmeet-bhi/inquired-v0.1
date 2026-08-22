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
        Schema::dropIfExists('testimonials');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('role_company')->nullable();
            $table->text('message');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });
    }
};
