<?php

namespace App\Repositories\Interfaces;

interface MaterialCategoryRepositoryInterface extends BaseRepositoryInterface
{
    // Method spesifik jika diperlukan
    public function findByName(string $name);
}
