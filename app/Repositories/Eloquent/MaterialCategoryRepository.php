<?php

namespace App\Repositories\Eloquent;

use App\Models\MaterialCategory;
use App\Repositories\Interfaces\MaterialCategoryRepositoryInterface;

class MaterialCategoryRepository extends BaseRepository implements MaterialCategoryRepositoryInterface
{
    public function __construct(MaterialCategory $model)
    {
        parent::__construct($model);
    }

    // Method spesifik jika diperlukan
    public function findByName(string $name)
    {
        return $this->model->where('name', $name)->first();
    }
}
