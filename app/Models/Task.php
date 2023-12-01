<?php

namespace App\Models;


use App\Models\User;

class Task extends TaskAppModel
{
    protected $fillable = ['user_id', 'title', 'description', 'status'];

    protected $attributes = [
        'status' => 0,
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
