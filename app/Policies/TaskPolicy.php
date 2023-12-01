<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }
}
