<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    // Constructor untuk inject model User
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    // Implementasi method spesifik
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByRole(int $roleId)
    {
        return $this->model->where('role_id', $roleId)->get();
    }

    // Override method all untuk selalu load relasi role
    public function all(array $columns = ['*'], array $relations = ['role'])
    {
        return parent::all($columns, $relations);
    }

    // Override method find untuk selalu load relasi role
    public function find(int $id, array $columns = ['*'], array $relations = ['role'])
    {
        return parent::find($id, $columns, $relations);
    }

    // Override method create untuk load relasi role
    public function create(array $data)
    {
        $model = parent::create($data);
        return $model->load('role');
    }

    // Override method update untuk load relasi role
    public function update(int $id, array $data)
    {
        $model = parent::update($id, $data);
        return $model->load('role');
    }
}
