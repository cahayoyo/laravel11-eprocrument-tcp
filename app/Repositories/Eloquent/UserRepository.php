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
}
