<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\IRepository;
use App\Policies\TaskPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(IRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function listUserTask(): JsonResponse
    {
        // Ensure the user is authenticated with a valid token
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Retrieve tasks for the authenticated user
        $tasks = $this->taskRepository->allTasksForUser($user->id);

        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'No tasks found for the user'], 404);
        }

        return response()->json(['message' => 'Tasks found', 'tasks' => $tasks], 200);
    }

    public function show($id)
    {
        $task = $this->taskRepository->listTaskById($id);

        if (!$task) {
            return response()->json(['message' => 'No Task found for the given task Id: ' . $id], 404);
        }

        return response()->json(['message' => 'Task found', 'task' => $task], 200);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $taskData = $request->all();

        $taskData['user_id'] = auth()->id();
        $task = $this->taskRepository->create($taskData);

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    public function update(Request $request, $id)
    {
        $task = $this->taskRepository->listTaskById($id);

        if (!$task) {
            return response()->json(['message' => 'No Task found for the given task Id: ' . $id], 404);
        }

        $this->authorize('update', $task);	// Check if the authenticated user can update the task

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'boolean',
        ]);

        $updateTask = $this->taskRepository->edit($id, $request->all());

        return response()->json(['message' => 'Task updated successfully', 'task' => $updateTask], 200);
    }

    public function delete($id)
    {
        $task = $this->taskRepository->listTaskById($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        if (!$this->authorize('delete', $task)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $this->taskRepository->delete($id);

        return response()->json(['message' => 'Task deleted successfully'], 200);
    }

}
