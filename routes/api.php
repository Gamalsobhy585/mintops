<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\API\V1\CategoryController;

use App\Http\Controllers\Api\V1\TeamController;



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
    });
});