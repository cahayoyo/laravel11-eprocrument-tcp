<?php

namespace App\Services;

use App\Repositories\Interfaces\VendorRepositoryInterface;
use Illuminate\Support\Facades\Log;

class VendorService
{
    protected $vendorRepository;

    public function __construct(VendorRepositoryInterface $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    public function getAll()
    {
        try {
            return $this->vendorRepository->all();
        } catch (\Exception $e) {
            Log::error('Get all vendors error: ' . $e->getMessage());
            throw new \Exception('Failed to get vendors');
        }
    }

    public function create(array $data)
    {
        try {
            // Validasi NPWP dan nomor registrasi
            if ($this->vendorRepository->findByTaxNumber($data['tax_number'])) {
                throw new \Exception('Tax number already registered');
            }

            if ($this->vendorRepository->findByRegistrationNumber($data['registration_number'])) {
                throw new \Exception('Registration number already registered');
            }

            return $this->vendorRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Create vendor error: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function update(int $id, array $data)
    {
        try {
            // Cek apakah vendor exist
            $vendor = $this->vendorRepository->find($id);
            if (!$vendor) {
                throw new \Exception('Vendor not found');
            }

            // Validasi NPWP dan nomor registrasi (kecuali untuk vendor yang sedang diupdate)
            $taxNumberExists = $this->vendorRepository->findByTaxNumber($data['tax_number']);
            if ($taxNumberExists && $taxNumberExists->id !== $id) {
                throw new \Exception('Tax number already registered');
            }

            $regNumberExists = $this->vendorRepository->findByRegistrationNumber($data['registration_number']);
            if ($regNumberExists && $regNumberExists->id !== $id) {
                throw new \Exception('Registration number already registered');
            }

            return $this->vendorRepository->update($id, $data);
        } catch (\Exception $e) {
            Log::error('Update vendor error: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            // Cek apakah vendor exist
            $vendor = $this->vendorRepository->find($id);
            if (!$vendor) {
                throw new \Exception('Vendor not found');
            }

            return $this->vendorRepository->delete($id);
        } catch (\Exception $e) {
            Log::error('Delete vendor error: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function find(int $id)
    {
        try {
            $vendor = $this->vendorRepository->find($id);
            if (!$vendor) {
                throw new \Exception('Vendor not found');
            }
            return $vendor;
        } catch (\Exception $e) {
            Log::error('Find vendor error: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function findByStatus(string $status)
    {
        try {
            return $this->vendorRepository->findByStatus($status);
        } catch (\Exception $e) {
            Log::error('Find vendors by status error: ' . $e->getMessage());
            throw new \Exception('Failed to get vendors');
        }
    }
}
