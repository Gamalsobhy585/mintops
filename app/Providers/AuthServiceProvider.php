<?php

namespace App\Providers;

use App\Models\Team;
use App\Policies\TeamPolicy;
use App\Models\Task;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Task::class => TaskPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Define custom gate for viewing deleted tasks
        Gate::define('view-deleted-tasks', [TaskPolicy::class, 'viewDeletedTasks']);
    }
}
