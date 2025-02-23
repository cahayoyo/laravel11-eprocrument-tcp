<?php

namespace Tests\Feature\Api\V1\Role;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_roles(): void
    {
        // Seed role
        $this->seed([\Database\Seeders\RoleSeeder::class]);

        $response = $this->getJson('/api/v1/roles');

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
                        'description',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
    }

    public function test_can_create_role(): void
    {
        $roleData = [
            'name' => 'Test Role',
            'description' => 'Test Description'
        ];

        $response = $this->postJson('/api/v1/roles', $roleData);

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
                    'description',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('roles', $roleData);
    }

    public function test_can_update_role(): void
    {
        $role = Role::create([
            'name' => 'Old Role',
            'description' => 'Old Description'
        ]);

        $updateData = [
            'name' => 'Updated Role',
            'description' => 'Updated Description'
        ];

        $response = $this->putJson("/api/v1/roles/{$role->id}", $updateData);

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
                    'description',
                    'created_at',
                    'updated_at'
                ]
            ]);

        $this->assertDatabaseHas('roles', $updateData);
    }

    public function test_can_delete_role(): void
    {
        $role = Role::create([
            'name' => 'Role to Delete',
            'description' => 'Will be deleted'
        ]);

        $response = $this->deleteJson("/api/v1/roles/{$role->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'code',
                    'status',
                    'message'
                ]
            ]);

        $this->assertSoftDeleted('roles', ['id' => $role->id]);
    }

    public function test_cannot_create_duplicate_role(): void
    {
        $roleName = 'Duplicate Role';

        // Create first role
        Role::create([
            'name' => $roleName,
            'description' => 'First Role'
        ]);

        // Try to create duplicate
        $response = $this->postJson('/api/v1/roles', [
            'name' => $roleName,
            'description' => 'Duplicate Role'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_cannot_delete_nonexistent_role(): void
    {
        $nonExistentId = 9999;

        $response = $this->deleteJson("/api/v1/roles/{$nonExistentId}");

        $response->assertStatus(404)
            ->assertJson([
                'meta' => [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Role not found'
                ]
            ]);
    }
}
