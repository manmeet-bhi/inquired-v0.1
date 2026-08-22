<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('admin_user_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_published')->default(false)->after('status');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['admin_user_id']);
            $table->dropColumn(['admin_user_id', 'is_published']);
        });
    }
};