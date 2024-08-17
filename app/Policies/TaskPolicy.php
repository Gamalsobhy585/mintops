<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Task $task)
    {
        return $user->isLeader() || $task->user_id == $user->id;
    }

    public function create(User $user)
    {
        return $user->isLeader();
    }

    public function update(User $user, Task $task)
    {
        return $user->isLeader() || $task->user_id == $user->id;
    }

    public function delete(User $user, Task $task)
    {
        return $user->isLeader() || $task->user_id == $user->id;
    }

    public function restore(User $user, Task $task)
    {
        return $user->isLeader();
    }

    public function forceDelete(User $user, Task $task)
    {
        return false; // Disable force delete
    }
}

