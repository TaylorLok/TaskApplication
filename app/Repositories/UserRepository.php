<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements IUserRepository
{
    public function find($userId)
    {
        return User::findOrFail($userId);
    }
}
