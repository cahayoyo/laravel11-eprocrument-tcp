<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Role\StoreRoleRequest;
use App\Http\Requests\Api\V1\Role\UpdateRoleRequest;
use App\Http\Resources\Api\V1\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        try {
            $roles = $this->roleService->getAll();

            return ResponseFormatter::success(
                data: RoleResource::collection($roles),
                message: 'Roles retrieved successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Get roles error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: 'Failed to retrieve roles',
                code: 500
            );
        }
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            $role = $this->roleService->create($request->validated());

            return ResponseFormatter::success(
                data: new RoleResource($role),
                message: 'Role created successfully',
                code: 201
            );
        } catch (\Exception $e) {
            Log::error('Create role error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: 'Failed to create role',
                code: 500
            );
        }
    }

    public function show($id)
    {
        try {
            $role = $this->roleService->find($id);

            return ResponseFormatter::success(
                data: new RoleResource($role),
                message: 'Role retrieved successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Get role error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: 'Role not found',
                code: 404
            );
        }
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            Log::info('Update role request:', [
                'id' => $id,
                'data' => $request->validated()
            ]);

            $role = $this->roleService->update($id, $request->validated());

            return ResponseFormatter::success(
                data: new RoleResource($role),
                message: 'Role updated successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Update role error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return ResponseFormatter::error(
                message: 'Failed to update role',
                code: 500
            );
        }
    }

    public function destroy($id)
    {
        try {
            // Cek apakah role ada
            $role = $this->roleService->find($id);

            if (!$role) {
                return ResponseFormatter::error(
                    message: 'Role not found',
                    code: 404
                );
            }

            $this->roleService->delete($id);

            return ResponseFormatter::success(
                message: 'Role deleted successfully',
                code: 200
            );
        } catch (\Exception $e) {
            Log::error('Delete role error: ' . $e->getMessage());
            return ResponseFormatter::error(
                message: 'Failed to delete role',
                code: 500
            );
        }
    }
}
