<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            try {
                $table->dropUnique(['user_id', 'liked_user_id']);
            } catch (\Throwable $e) {
                // index may not exist on some environments; ignore
            }
        });
    }

    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->unique(['user_id', 'liked_user_id']);
        });
    }
};

