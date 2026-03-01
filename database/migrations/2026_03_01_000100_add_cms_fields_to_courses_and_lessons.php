<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->after('thumbnail');
            $table->timestamp('published_at')->nullable()->after('status');
            $table->foreignId('updated_by')->nullable()->after('published_at')->constrained('users')->nullOnDelete();
            $table->softDeletes();
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->after('order');
            $table->timestamp('published_at')->nullable()->after('status');
            $table->boolean('is_preview')->default(false)->after('published_at');
            $table->foreignId('updated_by')->nullable()->after('is_preview')->constrained('users')->nullOnDelete();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['status', 'published_at', 'is_preview']);
            $table->dropConstrainedForeignId('updated_by');
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['status', 'published_at']);
            $table->dropConstrainedForeignId('updated_by');
        });
    }
};

