<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function createTask(CreateTaskRequest $request)
    {
        $this->authorize('create', Task::class);
    
        $task = $this->taskService->createTask($request->validated());
    
        return response()->json($task, 201);
    }

    public function editTask(UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);

        $validated = $request->validated();

        $task = $this->taskService->editTask($id, $validated);

        return response()->json($task, 200);
    }

    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
    
       
        $this->authorize('delete', $task);
    
        
        $this->taskService->deleteTask($id);
    
        return response()->json(null, 204);
    }
    
    

    public function restoreTask($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
    
        $this->authorize('restore', $task);
    
        $task = $this->taskService->restoreTask($id);
    
        return response()->json($task, 200);
    }
    

    public function assignTaskToMember(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('assign', $task);

        $userId = $request->input('user_id');
        $task = $this->taskService->assignTaskToMember($id, $userId);

        return response()->json($task, 200);
    }

    public function removeTaskFromMember($id, $userId)
    {
        $task = Task::findOrFail($id);
        $this->authorize('assign', $task);

        $task = $this->taskService->removeTaskFromMember($id, $userId);

        return response()->json($task, 200);
    }

    public function reassignTaskToMember(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('assign', $task);

        $newUserId = $request->input('user_id');
        $task = $this->taskService->reassignTaskToMember($id, $newUserId);

        return response()->json($task, 200);
    }

    public function index(Request $request)
{
    $tasks = $this->taskService->index($request->all());

    return response()->json($tasks);
}

}
