<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCourseCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
            'password' => 'password',
        ]);
    }

    public function test_admin_can_create_course(): void
    {
        $admin = $this->admin();

        $payload = [
            'title' => 'Test Course',
            'description' => 'Desc',
            'is_paid' => false,
            'status' => 'draft',
        ];

        $this->actingAs($admin)
            ->post(route('admin.courses.store'), $payload)
            ->assertRedirect();

        $this->assertDatabaseHas('courses', ['title' => 'Test Course', 'status' => 'draft']);
    }

    public function test_admin_can_update_course(): void
    {
        $admin = $this->admin();
        $course = Course::create([
            'title' => 'Old',
            'description' => 'Desc',
            'is_paid' => false,
            'status' => 'draft',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.courses.update', $course), [
                'title' => 'New',
                'description' => 'Desc',
                'is_paid' => false,
                'status' => 'published',
            ])
            ->assertRedirect(route('admin.courses.edit', $course));

        $this->assertDatabaseHas('courses', ['id' => $course->id, 'title' => 'New', 'status' => 'published']);
    }

    public function test_admin_can_soft_delete_course(): void
    {
        $admin = $this->admin();
        $course = Course::create([
            'title' => 'To Delete',
            'description' => 'Desc',
            'is_paid' => false,
            'status' => 'draft',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.courses.destroy', $course))
            ->assertSessionHas('success');

        $this->assertSoftDeleted('courses', ['id' => $course->id]);
    }
}

