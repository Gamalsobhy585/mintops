<?php
namespace App\Services;

use App\Models\Team;
use App\Models\User;

interface TeamServiceInterface
{
    /**
     * Create a new team.
     *
     * @param User $leader
     * @param array $data
     * @return Team
     */
    public function createTeam(User $leader, array $data): Team;
    
    /**
     * Add a member to a team.
     *
     * @param Team $team
     * @param User $user
     */
    public function addMember(Team $team, User $user);
    
    /**
     * Remove a member from a team.
     *
     * @param Team $team
     * @param User $user
     */
    public function removeMember(Team $team, User $user);

    /**
     * Delete a team.
     *
     * @param Team $team
     */
    public function deleteTeam(Team $team);
    public function getTeamMembers(Team $team);
}


