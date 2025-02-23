<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
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
        // Hash password sebelum disimpan
        $data['password'] = Hash::make($data['password']);

        // Set status default ke active
        $data['status'] = 'active';

        // Simpan user baru
        $user = $this->userRepository->create($data);

        // Buat token untuk API
        $token = $user->createToken('auth-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
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
        // Hapus token yang sedang digunakan
        $user->currentAccessToken()->delete();

        return true;
    }
}
