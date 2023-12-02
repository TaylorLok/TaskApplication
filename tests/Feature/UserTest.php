<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_user_can_register()
    {
        config(['database.default' => 'mysql_testing']);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'Taylor Lokombe',
            'email' => 'taylor@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => 'Taylor Lokombe',
            'email' => 'taylor@test.com',
        ]);
    }

    public function test_user_can_login()
    {
        config(['database.default' => 'mysql_testing']);


        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'status' => true,
                    'message' => 'User Logged In Successfully',
                ])
                ->assertJsonStructure([
                    'status',
                    'message',
                    'token',
                ]);

        $this->assertNotNull($response->json('token'));
    }
}
