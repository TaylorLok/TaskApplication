<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\IRepository;
use App\Policies\TaskPolicy;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(IRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function ListUserTask()
    {
        $tasks = $this->taskRepository->allTasksForUser(auth()->id());
        return response()->json($tasks);
    }

    public function show($id)
    {
        $task = $this->taskRepository->listTaskById($id);
        return response()->json($task);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'boolean',
        ]);

        $taskData = $request->all();
        $taskData['user_id'] = auth()->id();
        $task = $this->taskRepository->create($taskData);

        return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {
        $this->authorize(TaskPolicy::class, $this->taskRepository->edit($id, $request->all()));

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'boolean',
        ]);

        $task = $this->taskRepository->edit($id, $request->all());

        return response()->json($task);
    }

    public function delete($id)
    {
        $this->taskRepository->delete($id);

        return response()->json(null, 204);
    }

}
