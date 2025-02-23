<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    // Method spesifik untuk User jika diperlukan
    public function findByEmail(string $email);
}
