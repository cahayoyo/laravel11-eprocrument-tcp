<?php

namespace App\Services;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Support\Facades\Log;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAll()
    {
        try {
            return $this->roleRepository->all();
        } catch (\Exception $e) {
            Log::error('Get all roles error: ' . $e->getMessage());
            throw new \Exception('Failed to get roles');
        }
    }

    public function create(array $data)
    {
        try {
            return $this->roleRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Create role error: ' . $e->getMessage());
            throw new \Exception('Failed to create role');
        }
    }

    public function update(int $id, array $data)
    {
        try {
            return $this->roleRepository->update($id, $data);
        } catch (\Exception $e) {
            Log::error('Update role error: ' . $e->getMessage());
            throw new \Exception('Failed to update role');
        }
    }

    public function delete(int $id)
    {
        try {
            return $this->roleRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Delete role error: ' . $e->getMessage());
            throw new \Exception('Failed to delete role');
        }
    }

    public function find(int $id)
    {
        try {
            return $this->roleRepository->find($id);
        } catch (\Exception $e) {
            Log::error('Find role error: ' . $e->getMessage());
            throw new \Exception('Role not found');
        }
    }
}
