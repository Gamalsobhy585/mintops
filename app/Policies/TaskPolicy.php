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
        $isTaskOwner = $user->id === $task->user_id;
        $isTeamLeader = $user->id === $task->team->leader_id;
    
        return $isTaskOwner || $isTeamLeader;
    }
    
    
    public function delete(User $user, Task $task)
    {
        $teamLeader = $task->team->leader ?? null;
    
        return $teamLeader && $user->id === $teamLeader->id;
    }
    

    public function assign(User $user, Task $task)
    {
        return $user->role === 'leader' && $user->id === $task->user->leader->id;
    }

    public function view(User $user, Task $task)
    {
        if ($user->role === 'leader') {
            return $user->teams()->whereHas('tasks', function ($query) use ($task) {
                $query->where('id', $task->id);
            })->exists();
        }

        return $user->id === $task->user_id || $user->teams()->whereHas('tasks', function ($query) use ($task) {
            $query->where('id', $task->id);
        })->exists();
    }
    public function restore(User $user, Task $task)
{
    $teamLeader = $task->team->leader ?? null;

    return $teamLeader && $user->id === $teamLeader->id;
}

}
