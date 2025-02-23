<?php

namespace Tests\Feature\Api\V1\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([\Database\Seeders\RoleSeeder::class]);
    }

    public function test_can_get_all_users(): void
    {
        $role = Role::where('name', 'Vendor')->first();
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $role->id,
            'status' => 'active'
        ]);

        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'code',
                    'status',
                    'message'
                ],
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'status',
                        'role',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function test_can_create_user(): void
    {
        $role = Role::where('name', 'Vendor')->first();
        $userData = [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role_id' => $role->id,
            'status' => 'active'
        ];

        $response = $this->postJson('/api/v1/users', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'meta' => [
                    'code',
                    'status',
                    'message'
                ],
                'data' => [
                    'id',
                    'name',
                    'email',
                    'status',
                    'role'
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'new@example.com',
            'role_id' => $role->id
        ]);
    }

    public function test_can_update_user(): void
    {
        $role = Role::where('name', 'Vendor')->first();
        $user = User::create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $role->id,
            'status' => 'active'
        ]);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'role_id' => $role->id,
            'status' => 'active'
        ];

        $response = $this->putJson("/api/v1/users/{$user->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'code',
                    'status',
                    'message'
                ],
                'data' => [
                    'id',
                    'name',
                    'email',
                    'status',
                    'role'
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com'
        ]);
    }

    public function test_can_delete_user(): void
    {
        $role = Role::where('name', 'Vendor')->first();
        $user = User::create([
            'name' => 'To Delete',
            'email' => 'delete@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $role->id,
            'status' => 'active'
        ]);

        $response = $this->deleteJson("/api/v1/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'User deleted successfully'
                ]
            ]);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_cannot_create_user_with_duplicate_email(): void
    {
        $role = Role::where('name', 'Vendor')->first();

        // Create first user
        User::create([
            'name' => 'First User',
            'email' => 'duplicate@example.com',
            'password' => bcrypt('password123'),
            'role_id' => $role->id,
            'status' => 'active'
        ]);

        // Try to create user with same email
        $response = $this->postJson('/api/v1/users', [
            'name' => 'Second User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role_id' => $role->id,
            'status' => 'active'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
