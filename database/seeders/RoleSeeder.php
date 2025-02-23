<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Super Admin with all permissions'
            ],
            [
                'name' => 'Procurement Staff',
                'description' => 'Staff for managing procurement process'
            ],
            [
                'name' => 'Vendor',
                'description' => 'External vendor/supplier'
            ],
            [
                'name' => 'Project Manager',
                'description' => 'Manager for handling projects'
            ],
            [
                'name' => 'Finance',
                'description' => 'Staff for managing financial aspects'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
