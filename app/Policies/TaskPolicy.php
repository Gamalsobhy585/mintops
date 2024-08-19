<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function create(User $user)
    {
        return $user->role === 'leader';
    }

    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id || $user->id === $task->user->leader->id;
    }

    public function delete(User $user, Task $task)
    {
        return $user->role === 'leader' && $user->id === $task->user->leader->id;
    }

    public function assign(User $user, Task $task)
    {
        return $user->role === 'leader' && $user->id === $task->user->leader->id;
    }

    public function view(User $user, Task $task)
    {
        return $user->teams()->whereHas('tasks', function ($query) use ($task) {
            $query->where('id', $task->id);
        })->exists();
    }
}
