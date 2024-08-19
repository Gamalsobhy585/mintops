<?php
namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Team $team)
    {
        return $user->teams()->contains($team);
    }

    public function create(User $user)
    {
        return $user->role === 'leader';
    }

    public function update(User $user, Team $team)
    {
        return $user->id === $team->leader_id;
    }

    public function delete(User $user, Team $team)
    {
        return $user->id === $team->leader_id;
    }
}
