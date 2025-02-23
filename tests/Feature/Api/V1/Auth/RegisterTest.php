<?php

namespace Tests\Feature\Api\V1\Auth;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Jalankan seeder role untuk setiap test
        $this->seed([\Database\Seeders\RoleSeeder::class]);
    }

    public function test_user_can_register(): void
    {
        $role = Role::where('name', 'Vendor')->first();

        $response = $this->postJson('/api/v1/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role_id' => $role->id,
            'phone' => '08123456789'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'code',
                    'status',
                    'message'
                ],
                'data' => [
                    'user' => [
                        'id',
                        'name',
                        'email'
                    ],
                    'token'
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role_id' => $role->id
        ]);
    }
}
