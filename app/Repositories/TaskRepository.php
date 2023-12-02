<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository implements IRepository
{

    public function allTasksForUser($userId)
    {
        return Task::where('user_id', $userId)->get();
    }

    public function listTaskById($id)
    {
        $task = Task::find($id);

        return  $task;
    }

    public function create($data)
    {
        $task = Task::create($data);

        if(!$task) {
            return response()->json(['error' => 'Task not created'], 404);
        }else{
            return $task;
        }
    }

    public function edit($id, $data)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found for task Id ' . $id], 404);
        }

        $task->update($data);

        return $task;
    }

    public function delete($id)
    {
        $task = Task::find($id);

        $task->delete();
    }

}
