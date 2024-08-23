<?php

namespace App\Services;
use App\Models\User;

interface TaskServiceInterface
{
    public function createTask(array $data);
    public function editTask(int $taskId, array $data);
    public function deleteTask(int $taskId);
    public function restoreTask(int $taskId);
    public function assignTaskToMember(int $taskId, int $userId);
    public function removeTaskFromMember(int $taskId, int $userId);
    public function reassignTaskToMember(int $taskId, int $newUserId);
    public function index(array $criteria);
    public function getDeletedTasks(User $user, array $criteria = []);    
}
