<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;

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
    public function getTasksByTeamId($teamId)
    {
        return Task::whereExists(function ($query) use ($teamId) {
            $query->select(DB::raw(1))
                ->from('users')
                ->whereColumn('tasks.user_id', 'users.id')
                ->whereExists(function ($query) use ($teamId) {
                    $query->select(DB::raw(1))
                        ->from('teams')
                        ->join('team_user', 'teams.id', '=', 'team_user.team_id')
                        ->whereColumn('users.id', 'team_user.user_id')
                        ->where('teams.id', $teamId); 
                })
                ->whereNull('users.deleted_at');
        })
        ->whereNull('tasks.deleted_at')
        ->get();
    }
    

    public function getTasksByUserId(int $userId)
    {
        return Task::where('user_id', $userId)->get();
    }
    public function getDeletedTasks(array $criteria = [])
    {
        $query = Task::onlyTrashed();

        if (isset($criteria['team_id'])) {
            $query->where('team_id', $criteria['team_id']);
        }

        if (isset($criteria['user_id'])) {
            $query->where('user_id', $criteria['user_id']);
        }

        return $query->get();
    }
}
