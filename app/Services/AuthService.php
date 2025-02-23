<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // Method untuk register
    public function register(array $data)
    {
        try {
            // Hash password
            $data['password'] = Hash::make($data['password']);

            // Set status active
            $data['status'] = 'active';

            // Create user
            $user = $this->userRepository->create($data);

            // Generate token
            $token = $user->createToken('auth-token')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token
            ];
        } catch (\Exception $e) {
            // Logging data
            Log::error('Register service error: ' . $e->getMessage());

            throw new \Exception('Failed to register user');
        }
    }

    // Method untuk login
    public function login(array $credentials)
    {
        // Cari user berdasarkan email
        $user = $this->userRepository->findByEmail($credentials['email']);

        // Cek apakah user ditemukan dan password cocok
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Cek status user
        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'email' => ['Your account is inactive.'],
            ]);
        }

        // Buat token untuk API
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    // Method untuk logout
    public function logout($user)
    {
        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        // Delete the current token
        return $user->currentAccessToken()->delete();
    }
}
