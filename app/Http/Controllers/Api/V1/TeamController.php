<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Services\TeamServiceInterface;
use App\Repositories\TeamRepositoryInterface;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserCollection;

class TeamController extends Controller
{
    protected $teamService;
    protected $teamRepository;

    public function __construct(TeamServiceInterface $teamService, TeamRepositoryInterface $teamRepository)
    {
        $this->teamService = $teamService;
        $this->teamRepository = $teamRepository;
    }

    public function store(TeamRequest $request)
    {
        $this->authorize('create', Team::class);

        $team = $this->teamService->createTeam(Auth::user(), $request->validated());

        return new TeamResource($team);
    }

    public function addMember(Team $team, User $user)
    {
        $this->authorize('update', $team);

        $this->teamService->addMember($team, $user);

        return response()->json(['message' => 'Member added to the team.']);
    }

    public function removeMember(Team $team, User $user)
    {
        $this->authorize('update', $team);

        $this->teamService->removeMember($team, $user);

        return response()->json(['message' => 'Member removed from the team.']);
    }
    public function index()
    {
        $user = Auth::user();
        $teams = Team::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->orWhere('leader_id', $user->id)->get();
    
        return new TeamCollection($teams);
    }

    public function destroy(Team $team)
    {
        $this->authorize('delete', $team); 

        $this->teamService->deleteTeam($team);

        return response()->json(['message' => 'Team deleted successfully.']);
    }
    public function getMembers(Team $team)
    {
        $this->authorize('view', $team);

        $members = $this->teamService->getTeamMembers($team);

        return new UserCollection($members);  
    }
}

