<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('transport_routes') && ! Schema::hasColumn('transport_routes', 'stops')) {
            Schema::table('transport_routes', function (Blueprint $table) {
                $table->json('stops')->nullable()->after('interval');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('transport_routes') && Schema::hasColumn('transport_routes', 'stops')) {
            Schema::table('transport_routes', function (Blueprint $table) {
                $table->dropColumn('stops');
            });
        }
    }
};
