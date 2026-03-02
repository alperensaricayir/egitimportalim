<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLessonCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
            'password' => 'password',
        ]);
    }

    protected function course(): Course
    {
        return Course::create([
            'title' => 'Course',
            'description' => 'Desc',
            'is_paid' => false,
            'status' => 'draft',
        ]);
    }

    public function test_admin_can_create_lesson(): void
    {
        $admin = $this->admin();
        $course = $this->course();

        $payload = [
            'title' => 'Lesson 1',
            'content' => 'Content',
            'video_url' => null,
            'order' => 0,
            'status' => 'draft',
        ];

        $this->actingAs($admin)
            ->post(route('admin.lessons.store', $course), $payload)
            ->assertRedirect(route('admin.courses.edit', $course));

        $this->assertDatabaseHas('lessons', ['course_id' => $course->id, 'title' => 'Lesson 1']);
    }

    public function test_admin_can_update_lesson(): void
    {
        $admin = $this->admin();
        $course = $this->course();
        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'Old',
            'content' => 'Content',
            'order' => 0,
            'status' => 'draft',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.lessons.update', [$course, $lesson]), [
                'title' => 'New',
                'content' => 'Content Changed',
                'order' => 0,
                'status' => 'published',
                'video_url' => null,
            ])
            ->assertRedirect(route('admin.courses.edit', $course));

        $this->assertDatabaseHas('lessons', ['id' => $lesson->id, 'title' => 'New', 'status' => 'published']);
    }

    public function test_admin_can_delete_lesson(): void
    {
        $admin = $this->admin();
        $course = $this->course();
        $lesson = Lesson::create([
            'course_id' => $course->id,
            'title' => 'To Delete',
            'content' => 'Content',
            'order' => 0,
            'status' => 'draft',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.lessons.destroy', [$course, $lesson]))
            ->assertSessionHas('success');

        $this->assertSoftDeleted('lessons', ['id' => $lesson->id]);
    }
}

