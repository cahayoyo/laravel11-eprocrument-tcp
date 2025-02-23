<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\StoreUserRequest;
use App\Http\Requests\Api\V1\User\UpdateUserRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->getAll();

            return ResponseFormatter::success(
                data: UserResource::collection($users),
                message: 'Users retrieved successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Get users error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: 'Failed to retrieve users',
                code: 500
            );
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->create($request->validated());

            return ResponseFormatter::success(
                data: new UserResource($user),
                message: 'User created successfully',
                code: 201
            );
        } catch (\Exception $e) {
            Log::error('Create user error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: 'Failed to create user',
                code: 500
            );
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->find($id);

            if (!$user) {
                return ResponseFormatter::error(
                    message: 'User not found',
                    code: 404
                );
            }

            return ResponseFormatter::success(
                data: new UserResource($user),
                message: 'User retrieved successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Get user error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: 'User not found',
                code: 404
            );
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            // Check if user exists
            $user = $this->userService->find($id);

            if (!$user) {
                return ResponseFormatter::error(
                    message: 'User not found',
                    code: 404
                );
            }

            $user = $this->userService->update($id, $request->validated());

            return ResponseFormatter::success(
                data: new UserResource($user),
                message: 'User updated successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Update user error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: 'Failed to update user',
                code: 500
            );
        }
    }

    public function destroy($id)
    {
        try {
            // Check if user exists
            $user = $this->userService->find($id);

            if (!$user) {
                return ResponseFormatter::error(
                    message: 'User not found',
                    code: 404
                );
            }

            $this->userService->delete($id);

            return ResponseFormatter::success(
                message: 'User deleted successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Delete user error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: 'Failed to delete user',
                code: 500
            );
        }
    }
}
