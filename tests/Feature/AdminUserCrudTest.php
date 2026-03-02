<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): User
    {
        return User::factory()->create([
            'role' => 'admin',
            'password' => 'password',
        ]);
    }

    public function test_admin_can_view_users_index(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertStatus(200);
    }

    public function test_admin_can_create_user(): void
    {
        $admin = $this->admin();

        $payload = [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'secret12',
            'role' => 'user',
        ];

        $this->actingAs($admin)
            ->post(route('admin.users.store'), $payload)
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'new@example.com',
            'role' => 'user',
        ]);
    }

    public function test_admin_can_update_user(): void
    {
        $admin = $this->admin();
        $target = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)
            ->put(route('admin.users.update', $target), [
                'name' => 'Updated Name',
                'email' => $target->email,
                'password' => '',
                'role' => 'editor',
            ])
            ->assertRedirect(route('admin.users.edit', $target));

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'name' => 'Updated Name',
            'role' => 'editor',
        ]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_delete_other_user(): void
    {
        $admin = $this->admin();
        $target = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $target))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $target->id]);
    }
}

