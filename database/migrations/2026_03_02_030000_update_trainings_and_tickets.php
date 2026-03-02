<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('instructor')->nullable();
            $table->string('level')->nullable();
            $table->timestamp('starts_at')->nullable();
        });

        Schema::table('support_tickets', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->timestamp('sla_due_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropColumn(['category', 'sla_due_at']);
        });
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn(['instructor', 'level', 'starts_at']);
        });
    }
};

