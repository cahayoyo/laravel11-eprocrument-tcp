<?php

namespace App\Repositories\Eloquent;

use App\Models\Vendor;
use App\Repositories\Interfaces\VendorRepositoryInterface;

class VendorRepository extends BaseRepository implements VendorRepositoryInterface
{
    public function __construct(Vendor $model)
    {
        parent::__construct($model);
    }

    // Override method all untuk selalu load relasi user
    public function all(array $columns = ['*'], array $relations = ['user'])
    {
        return parent::all($columns, $relations);
    }

    // Override method find untuk selalu load relasi user
    public function find(int $id, array $columns = ['*'], array $relations = ['user'])
    {
        return parent::find($id, $columns, $relations);
    }

    // Override method create untuk load relasi user
    public function create(array $data)
    {
        $model = parent::create($data);
        return $model->load('user');
    }

    // Override method update untuk load relasi user
    public function update(int $id, array $data)
    {
        $model = parent::update($id, $data);
        return $model->load('user');
    }

    public function findByTaxNumber(string $taxNumber)
    {
        return $this->model->where('tax_number', $taxNumber)->first();
    }

    public function findByRegistrationNumber(string $registrationNumber)
    {
        return $this->model->where('registration_number', $registrationNumber)->first();
    }

    public function findByStatus(string $status)
    {
        return $this->model->where('status', $status)->get();
    }
}
