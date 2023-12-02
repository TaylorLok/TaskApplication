<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository implements IRepository
{

    public function allTasksForUser($userId)
    {
        $tasks = Task::where('user_id', $userId)->get();

        if (!$tasks) {
            return response()->json(['message' => 'No tasks found for user ' . $tasks->user->name], 404);
        }

        return response()->json(['message' => 'All tasks found', 'tasks' => $tasks], 200);
    }

    public function listTaskById($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'No Task found for the given task Id: ' . $id], 404);
        }

        return response()->json(['message' => 'Task found', 'task' => $task], 200);
    }

    public function create($data)
    {
        $task = Task::create($data);

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    public function edit($id, $data)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found for task Id ' . $id], 404);
        }

        $task->update($data);

        return response()->json(['message' => 'Task updated successfully', 'task' => $task], 200);
    }

    public function delete($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found for the given id ' . $id], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully'], 204);
    }

}
