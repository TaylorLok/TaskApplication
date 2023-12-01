<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TaskRepository;
use Validator;

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

        return view('tasks.index', compact('tasks'));
    }

    public function apiIndex(TaskRepository $taskRepository)
    {
        $tasks = $taskRepository->allTasksForUser(auth()->id());

        return response()->json(['tasks' => $tasks], 200);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function find($id)
    {
        if(!$id) {
            return redirect()->back()->with('error', 'Task not found');
        }
        $task = $this->taskRepository->listTaskById($id);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $task = $this->taskRepository->edit($id, $data);

        if (!$task) {
            return redirect()->back()->with('error', 'Task not found');
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
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

        return redirect()->route('tasks.index')->with('success', 'Task ' . ($data['id'] ? 'updated' : 'created') . ' successfully');
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

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
