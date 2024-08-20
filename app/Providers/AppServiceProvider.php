<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\TaskService;
use App\Services\TaskServiceInterface;
use App\Repositories\TaskRepository;
use App\Repositories\TaskRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

   
    public function boot(): void
    {
        //
    }
}
