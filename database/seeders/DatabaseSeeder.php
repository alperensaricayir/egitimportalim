<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Regular User
        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Editor User
        User::create([
            'name' => 'Content Editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
            'role' => 'editor',
        ]);

        // Sample Course 1
        $course1 = Course::create([
            'title' => 'Laravel 10 for Beginners',
            'description' => 'Learn the basics of Laravel 10 framework including routing, controllers, views, and database operations.',
            'is_paid' => false,
            'price' => 0.00,
        ]);

        Lesson::create([
            'course_id' => $course1->id,
            'title' => 'Introduction to Laravel',
            'content' => 'Laravel is a web application framework with expressive, elegant syntax.',
            'video_url' => 'https://www.youtube.com/embed/ImtZ5yENzgE', // Example embed URL
            'order' => 1,
        ]);

        Lesson::create([
            'course_id' => $course1->id,
            'title' => 'Routing and Controllers',
            'content' => 'Routing is the entry point of your application.',
            'order' => 2,
        ]);

        // Sample Course 2 (Paid)
        $course2 = Course::create([
            'title' => 'Advanced PHP Techniques',
            'description' => 'Master PHP with advanced concepts like OOP, Design Patterns, and more.',
            'is_paid' => true,
            'price' => 49.99,
        ]);

        Lesson::create([
            'course_id' => $course2->id,
            'title' => 'Object Oriented Programming',
            'content' => 'OOP is a programming paradigm based on the concept of "objects".',
            'order' => 1,
        ]);
    }
}
