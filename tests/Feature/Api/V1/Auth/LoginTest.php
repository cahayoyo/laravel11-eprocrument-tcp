<?php

namespace Tests\Feature\Api\V1\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([\Database\Seeders\RoleSeeder::class]);
    }

    public function test_user_can_login(): void
    {
        // Buat user untuk test
        $role = Role::where('name', 'Vendor')->first();
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $role->id,
            'status' => 'active'
        ]);

        // Test login
        $response = $this->postJson('/api/v1/login', [
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'code',
                    'status',
                    'message'
                ],
                'data' => [
                    'user',
                    'token'
                ]
            ]);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        // Buat user untuk test
        $role = Role::where('name', 'Vendor')->first();
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $role->id,
            'status' => 'active'
        ]);

        // Test login dengan password salah
        $response = $this->postJson('/api/v1/login', [
            'email' => 'john@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'meta' => [
                    'status' => 'error'
                ]
            ]);
    }
}
