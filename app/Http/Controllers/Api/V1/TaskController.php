<?php

namespace App\Http\Controllers;

use App\Services\TaskServiceInterface;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\CreateTaskRequest;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    public function createTask(CreateTaskRequest $request)
    {
        $this->authorize('create', Task::class);
    
        $task = $this->taskService->createTask($request->validated());
    
        return response()->json($task, 201);
    }

    public function editTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => 'in:completed,in progress,not started',
            'priority' => 'in:low,medium,high',
            'category_id' => 'exists:categories,id',
        ]);

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
        $this->authorize('restore', Task::class);

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
    $user = $request->user();
    
    if ($user->role === 'leader') {
        $tasks = Task::where('team_id', $user->team_id)->get();
    } else {
        $tasks = Task::where('user_id', $user->id)->get();
    }

    return response()->json($tasks, 200);
}
}
