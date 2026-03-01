<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
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

    public function view(User $user, Lesson $lesson): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function update(User $user, Lesson $lesson): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function delete(User $user, Lesson $lesson): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    public function restore(User $user, Lesson $lesson): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }
}

