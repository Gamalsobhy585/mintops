<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\TaskController;

Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('categories', [CategoryController::class, 'index'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('teams', [TeamController::class, 'index']);
        Route::post('teams/create', [TeamController::class, 'store']);
        Route::post('teams/{team}/members/{user}', [TeamController::class, 'addMember']);
        Route::delete('teams/{team}/members/{user}', [TeamController::class, 'removeMember']);
        Route::delete('teams/{team}', [TeamController::class, 'destroy']);

        // Task Routes
        Route::post('tasks', [TaskController::class, 'createTask']);
        Route::put('tasks/{task}', [TaskController::class, 'editTask']);
        Route::delete('tasks/{task}', [TaskController::class, 'deleteTask']);
        Route::patch('tasks/{task}/restore', [TaskController::class, 'restoreTask']);
        Route::post('tasks/{task}/assign', [TaskController::class, 'assignTaskToMember']);
        Route::delete('tasks/{task}/remove-member/{user}', [TaskController::class, 'removeTaskFromMember']);
        Route::post('tasks/{task}/reassign', [TaskController::class, 'reassignTaskToMember']);
    });
});
