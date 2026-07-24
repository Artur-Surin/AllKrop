<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->after('body');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }
};
