<?php 
namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeamService implements TeamServiceInterface
{
    public function createTeam(User $leader, array $data): Team
    {
        $team = Team::create([
            'name' => $data['name'],
            'leader_id' => $leader->id,
        ]);
    
        $team->users()->attach($leader->id);
    
        return $team;
    }
    

    public function addMember(Team $team, User $user)
    {
        // if ($team->hasMaxMembers()) {
        //     throw new \Exception('Team cannot have more than 5 members.');
        // }

        $team->users()->attach($user->id);
    }

    public function removeMember(Team $team, User $user)
    {
        $team->users()->detach($user->id);
    }

    public function deleteTeam(Team $team)
    {
        $team->delete(); 
    }
    public function getTeamMembers(Team $team)
    {
        return $team->users()->get();  
    }
}
