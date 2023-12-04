<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use Validator;
use Inertia\Inertia;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $tasks = $this->taskRepository->allTasksForUser(auth()->id());

        return Inertia::render('Dashboard', ['tasks' => $tasks]);
    }

    public function apiIndex(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->allTasksForUser(auth()->id());

        return response()->json(['tasks' => $tasks], 200);
    }

    public function create()
    {
        return Inertia::render('Task/Create', [
            'tasks' => $this->taskRepository->allTasksForUser(auth()->id()),
        ]);
    }

    public function show($id)
    {
        if(!$id) {
            return redirect()->route('home')->with('error', 'Task not found');
        }

       $this->taskRepository->listTaskById($id);

        return redirect()->route('home')->with('success', 'Task updated successfully!');
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();

        $task = $this->taskRepository->listTaskById($id);
        $this->authorize('update', $task);

        $task = $this->taskRepository->edit($id, $data);

        if (!$task) {
            return redirect()->back()->with('error', 'Task not found');
        }

        return redirect()->route('home')->with('success', 'Task updated successfully!');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, $this->getValidationRules($data));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['user_id'] = auth()->id();
        $task = $data['id'] ? $this->taskRepository->edit($data['id'], $data) : $this->taskRepository->create($data);

        return redirect()->route('home')->with('success', 'Task ' . ($data['id'] ? 'updated' : 'created') . ' successfully');
    }

    private function getValidationRules($data)
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ];
    }

    public function destroy($id)
    {
        if(!$id) {
            return redirect()->back()->with('error', 'Task not found');
        }
        $this->taskRepository->delete($id);

        return redirect()->route('home')->with('success', 'Task deleted successfully');
    }
}
