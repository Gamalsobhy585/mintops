<?php
namespace App\Repositories;

use App\Models\Team;

interface TeamRepositoryInterface
{
    public function findById($id): ?Team;
    
    public function save(Team $team);
    
    public function delete(Team $team);
}
