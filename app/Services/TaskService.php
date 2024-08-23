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
    if (!array_key_exists('team_id', $data)) {
        throw new \Exception('Team ID is required.');
    }

    $data['user_id'] = $data['user_id'] ?? auth()->id(); 

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
    
        User::find($userId)->notify(new TaskAssignedNotification($task));
        
        return $task;
    }
    
    public function removeTaskFromMember(int $taskId, int $userId)
    {
        $task = $this->taskRepository->find($taskId);
        if ($task->user_id == $userId) {
            $task->user_id = null;
            $task->save();
    
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
    public function index(array $data)
    {
        $user = auth()->user();
    
        if ($user->role === 'leader') {
            $teamId = $user->leadingTeams->first()->id ?? null; 
        } else {
            if ($user->teams->isEmpty()) {
                throw new \Exception('User does not belong to any team.');
            }
            $teamId = $user->teams->first()->id ?? null; 
        }
    
        if ($teamId === null) {
            throw new \Exception('Team ID is not set. Please ensure that the user is properly assigned to a team.');
        }
    
        return $this->taskRepository->getTasksByTeamId($teamId);
    }
    public function findTaskById(int $taskId)
    {
        return Task::find($taskId);
    }
public function getDeletedTasks(User $user, array $criteria = [])
{
    return $this->taskRepository->getDeletedTasks($user, $criteria);
}


}
