<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function before(User $user, string $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function view(User $user, Course $course): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function update(User $user, Course $course): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function delete(User $user, Course $course): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function restore(User $user, Course $course): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }
}

