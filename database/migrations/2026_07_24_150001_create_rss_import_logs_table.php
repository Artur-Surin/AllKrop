<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rss_import_logs', function (Blueprint $table) {
            $table->id();
            $table->string('feed_name');
            $table->string('feed_type');
            $table->integer('items_found')->default(0);
            $table->integer('items_imported')->default(0);
            $table->integer('items_skipped')->default(0);
            $table->string('status')->default('success');
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rss_import_logs');
    }
};
