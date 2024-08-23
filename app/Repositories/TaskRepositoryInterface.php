<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function restore(int $id);
    public function find(int $id);
    public function getTasksByTeamId(int $teamId); 
    public function getTasksByUserId(int $userId); 
    public function getDeletedTasks(User $user, array $criteria = []): Collection;
}