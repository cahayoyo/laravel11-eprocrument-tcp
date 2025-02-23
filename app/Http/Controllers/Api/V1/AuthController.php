<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Handle request register
    public function register(RegisterRequest $request)
    {
        try {
            $data = $this->authService->register($request->validated());

            return ResponseFormatter::success(
                data: $data,
                message: 'User registered successfully'
            );
        } catch (\Exception $e) {
            return ResponseFormatter::error(
                message: $e->getMessage()
            );
        }
    }

    // Handle request login
    public function login(LoginRequest $request)
    {
        try {
            $data = $this->authService->login($request->validated());

            return ResponseFormatter::success(
                data: $data,
                message: 'Logged in successfully'
            );
        } catch (\Exception $e) {
            return ResponseFormatter::error(
                message: $e->getMessage()
            );
        }
    }

    // Handle request logout
    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request->user());

            return ResponseFormatter::success(
                message: 'Logged out successfully'
            );
        } catch (\Exception $e) {
            return ResponseFormatter::error(
                message: $e->getMessage()
            );
        }
    }
}
