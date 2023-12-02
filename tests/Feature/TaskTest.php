<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/task/create', [
            'title' => 'Task Title',
            'description' => 'Task Description',
            'status' => 0,
        ]);

        $response->assertStatus(201);
    }

    public function test_user_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->putJson("/api/task/update/{$task->id}", [
            'title' => 'Updated Task Title',
            'description' => 'Updated Task Description',
            'status' => 1,
        ]);

        $response->assertStatus(200);
    }


    public function test_user_can_view_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/task/' . $task->id);

        $response->assertStatus(200);
    }

    public function test_user_can_view_user_tasks()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/user-tasks');

        $response->assertStatus(200);
    }

    public function test_user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->deleteJson("/api/task/delete/{$task->id}");

        $response->assertStatus(200);
    }
}
