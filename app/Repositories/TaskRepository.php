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

        return $task;
    }

    public function create($data)
    {
        $task = Task::create($data);

        return  $task;
    }

    public function edit($id, $data)
    {
        $task = Task::find($id);

        $task->update($data);

        return $task;
    }

    public function delete($id)
    {
        Task::find($id)->delete();
    }

}
