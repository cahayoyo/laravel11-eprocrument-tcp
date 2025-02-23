<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            // Logging data
            Log::info('Register data:', $request->validated());

            $data = $this->authService->register($request->validated());

            return ResponseFormatter::success(
                data: $data,
                message: 'User registered successfully',
                code: 201
            );
        } catch (\Exception $e) {
            // Logging data
            Log::error('Register error: ' . $e->getMessage());

            return ResponseFormatter::error(
                message: $e->getMessage(),
                code: 500
            );
        }
    }

    // Handle request login
    public function login(LoginRequest $request)
    {
        try {
            // Logging data
            Log::info('Login data:', $request->validated());

            $data = $this->authService->login($request->validated());

            return ResponseFormatter::success(
                data: $data,
                message: 'Logged in successfully',
                code: 200
            );
        } catch (\Exception $e) {
            // Logging data
            Log::error('Login error: ' . $e->getMessage());

            return ResponseFormatter::error(
                message: $e->getMessage(),
                code: 400
            );
        }
    }

    // Handle request logout
    public function logout(Request $request)
    {
        try {
            // Logging data
            Log::info('Logout user:', ['user' => $request->user()]);

            $this->authService->logout($request->user());

            return ResponseFormatter::success(
                message: 'Logged out successfully',
                code: 200
            );
        } catch (\Exception $e) {
            // Logging data
            Log::error('Logout error: ' . $e->getMessage());

            return ResponseFormatter::error(
                message: $e->getMessage(),
                code: 500
            );
        }
    }
}
