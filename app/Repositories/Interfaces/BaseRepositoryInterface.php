<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    // Mendapatkan semua data
    public function all(array $columns = ['*'], array $relations = []);

    // Mendapatkan data dengan paginasi
    public function paginate(int $perPage = 10, array $columns = ['*'], array $relations = []);

    // Mendapatkan data berdasarkan id
    public function find(int $id, array $columns = ['*'], array $relations = []);

    // Menyimpan data baru
    public function create(array $data);

    // Mengupdate data
    public function update(int $id, array $data);

    // Menghapus data
    public function delete(int $id);
}
