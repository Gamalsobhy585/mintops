<?php
namespace App\Repositories;

use App\Models\Team;

class TeamRepository implements TeamRepositoryInterface
{
    public function findById($id): ?Team
    {
        return Team::find($id);
    }

    public function save(Team $team)
    {
        $team->save();
    }

    public function delete(Team $team)
    {
        $team->delete();
    }
}
