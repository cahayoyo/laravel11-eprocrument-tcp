<?php

namespace App\Repositories\Interfaces;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    // Method spesifik untuk Role jika diperlukan
    public function findByName(string $name);
}
