<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            return;
        }

        DB::statement('PRAGMA foreign_keys=OFF');

        Schema::create('users_tmp', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'editor', 'user'])->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::statement('INSERT INTO users_tmp (id, name, email, email_verified_at, password, role, remember_token, created_at, updated_at)
                       SELECT id, name, email, email_verified_at, password, role, remember_token, created_at, updated_at
                       FROM users');

        Schema::drop('users');
        Schema::rename('users_tmp', 'users');

        DB::statement('PRAGMA foreign_keys=ON');
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            return;
        }

        DB::statement('PRAGMA foreign_keys=OFF');

        Schema::create('users_tmp', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::statement("INSERT INTO users_tmp (id, name, email, email_verified_at, password, role, remember_token, created_at, updated_at)
                       SELECT id, name, email, email_verified_at, password, CASE WHEN role = 'editor' THEN 'user' ELSE role END, remember_token, created_at, updated_at
                       FROM users");

        Schema::drop('users');
        Schema::rename('users_tmp', 'users');

        DB::statement('PRAGMA foreign_keys=ON');
    }
};

