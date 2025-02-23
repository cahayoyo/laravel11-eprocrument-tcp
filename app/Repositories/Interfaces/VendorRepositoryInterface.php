<?php

namespace App\Repositories\Interfaces;

interface VendorRepositoryInterface extends BaseRepositoryInterface
{
    // Method spesifik untuk Vendor
    public function findByTaxNumber(string $taxNumber);
    public function findByRegistrationNumber(string $registrationNumber);
    public function findByStatus(string $status);
}
