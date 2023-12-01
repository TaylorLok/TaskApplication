<?php

namespace App\Repositories;

interface IRepository
{
    public function allTasksForUser($userId);

    public function listTaskById($id);

    public function create($data);

    public function edit($id, $data);

    public function delete($id);
}
