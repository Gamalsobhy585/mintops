<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\TaskService;
use App\Services\TaskServiceInterface;
use App\Repositories\TaskRepository;
use App\Repositories\TaskRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
