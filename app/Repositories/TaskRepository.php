<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update(int $id, array $data)
    {
        $task = Task::findOrFail($id);
        $task->update($data);
        return $task;
    }

    public function delete(int $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }

    public function restore(int $id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();
        return $task;
    }

    public function find(int $id)
    {
        return Task::findOrFail($id);
    }
}
