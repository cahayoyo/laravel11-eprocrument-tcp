<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        try {
            return $this->userRepository->all();
        } catch (\Exception $e) {
            Log::error('Get all users error: ' . $e->getMessage());
            throw new \Exception('Failed to get users');
        }
    }

    public function create(array $data)
    {
        try {
            // Hash password if provided
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            return $this->userRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Create user error: ' . $e->getMessage());
            throw new \Exception('Failed to create user');
        }
    }

    public function update(int $id, array $data)
    {
        try {
            // Hash password only if provided
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']); // Remove password if not provided
            }

            return $this->userRepository->update($id, $data);
        } catch (\Exception $e) {
            Log::error('Update user error: ' . $e->getMessage());
            throw new \Exception('Failed to update user');
        }
    }

    public function delete(int $id)
    {
        try {
            return $this->userRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Delete user error: ' . $e->getMessage());
            throw new \Exception('Failed to delete user');
        }
    }

    public function find(int $id)
    {
        try {
            return $this->userRepository->find($id);
        } catch (\Exception $e) {
            Log::error('Find user error: ' . $e->getMessage());
            throw new \Exception('User not found');
        }
    }
}
