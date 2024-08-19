<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepositoryInterface;

use App\Notifications\TaskAssignedNotification;
use App\Notifications\TaskReassignedNotification;
use App\Notifications\TaskRemovedNotification;



class TaskService implements TaskServiceInterface
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function createTask(array $data)
    {
        return $this->taskRepository->create($data);
    }

    public function editTask(int $taskId, array $data)
    {
        return $this->taskRepository->update($taskId, $data);
    }

    public function deleteTask(int $taskId)
    {
        return $this->taskRepository->delete($taskId);
    }

    public function restoreTask(int $taskId)
    {
        return $this->taskRepository->restore($taskId);
    }

    public function assignTaskToMember(int $taskId, int $userId)
    {
        $task = $this->taskRepository->find($taskId);
        $task->user_id = $userId;
        $task->save();
    
        // Notify the user about the assignment
        User::find($userId)->notify(new TaskAssignedNotification($task));
        
        return $task;
    }
    
    public function removeTaskFromMember(int $taskId, int $userId)
    {
        $task = $this->taskRepository->find($taskId);
        if ($task->user_id == $userId) {
            $task->user_id = null;
            $task->save();
    
            // Notify the user about the removal
            User::find($userId)->notify(new TaskRemovedNotification($task));
        }
        return $task;
    }
    
    public function reassignTaskToMember(int $taskId, int $newUserId)
    {
        $task = $this->assignTaskToMember($taskId, $newUserId);
    
        // Notify the user about the reassignment
        User::find($newUserId)->notify(new TaskReassignedNotification($task));
    
        return $task;
    }
}
