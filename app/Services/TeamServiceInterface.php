<?php
namespace App\Services;

use App\Models\Team;
use App\Models\User;

interface TeamServiceInterface
{
    public function createTeam(User $leader, array $data): Team;
    
    public function addMember(Team $team, User $user);
    
    public function removeMember(Team $team, User $user);
}
