<?php 
namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeamService implements TeamServiceInterface
{
    public function createTeam(User $leader, array $data): Team
    {
        return DB::transaction(function () use ($leader, $data) {
            $team = Team::create([
                'name' => $data['name'],
                'leader_id' => $leader->id,
            ]);

            $team->users()->attach($leader->id);

            return $team;
        });
    }

    public function addMember(Team $team, User $user)
    {
        if ($team->users()->count() < 5) {
            $team->users()->attach($user->id);
            $user->notify(new \App\Notifications\AddedToTeam($team));
        } else {
            throw new \Exception('Team cannot have more than 5 members.');
        }
    }

    public function removeMember(Team $team, User $user)
    {
        if ($team->users()->detach($user->id)) {
            $user->notify(new \App\Notifications\RemovedFromTeam($team));
        }
    }
    public function deleteTeam(Team $team)
    {
        $team->delete(); 
    }
}
