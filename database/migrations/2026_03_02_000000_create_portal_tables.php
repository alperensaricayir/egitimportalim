<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Modify Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('avatar')->nullable();
        });

        // 2. Trainings Table
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('link');
            $table->string('image')->nullable();
            $table->boolean('is_premium')->default(false);
            $table->string('category')->nullable();
            $table->timestamps();
        });

        // 3. Support Tickets Table
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('subject');
            $table->text('message'); // Initial message
            $table->enum('status', ['open', 'answered', 'closed'])->default('open');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->timestamps();
        });

        // 4. Ticket Messages Table (Replies)
        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('support_tickets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who wrote the message
            $table->text('message');
            $table->timestamps();
        });

        // 5. Services Table
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // 6. Job Postings Table
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('city')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 7. Social Links Table
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('platform'); // e.g., 'instagram', 'linkedin'
            $table->string('url');
            $table->timestamps();
        });

        // 8. Likes Table
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liker
            $table->foreignId('liked_user_id')->constrained('users')->onDelete('cascade'); // Liked
            $table->timestamps();
            $table->unique(['user_id', 'liked_user_id']); // Prevent duplicate likes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('job_postings');
        Schema::dropIfExists('services');
        Schema::dropIfExists('ticket_messages');
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('trainings');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio', 'phone', 'city', 'avatar']);
        });
    }
};
