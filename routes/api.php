<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UserController;

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
 

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        //categories routes
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('categories/recently-visited', [CategoryController::class, 'recentlyVisited']);
        Route::get('categories/{id}', [CategoryController::class, 'show']);


        //teams routes
        Route::get('teams', [TeamController::class, 'index']);
        Route::post('teams/create', [TeamController::class, 'store']);
        Route::post('teams/{team}/members/{user}', [TeamController::class, 'addMember']);
        Route::delete('teams/{team}/members/{user}', [TeamController::class, 'removeMember']);
        Route::delete('teams/{team}', [TeamController::class, 'destroy']);
        Route::get('teams/{team}/members', [TeamController::class, 'getMembers']);
        
        //users routes
        Route::get('users', [UserController::class, 'index']);
       //tasks routes 
        Route::post('tasks', [TaskController::class, 'createTask']);
        Route::get('tasks', [TaskController::class, 'index']); 
        Route::get('/tasks/{task}', [TaskController::class, 'showTask'])->where('task', '[0-9]+');
        Route::put('tasks/{task}', [TaskController::class, 'editTask']);
        Route::delete('tasks/{task}', [TaskController::class, 'deleteTask']);
        Route::patch('tasks/{task}/restore', [TaskController::class, 'restoreTask']);
        Route::post('tasks/{task}/assign', [TaskController::class, 'assignTaskToMember']);
        Route::delete('tasks/{task}/remove-member/{user}', [TaskController::class, 'removeTaskFromMember']);
        Route::post('tasks/{task}/reassign', [TaskController::class, 'reassignTaskToMember']);
        Route::get('tasks/deleted', [TaskController::class, 'getDeletedTasks']);

    });
});
