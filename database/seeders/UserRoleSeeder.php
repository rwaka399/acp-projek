<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::first(); // Assuming the first user is admin
        $roleAdmin = \App\Models\Role::where('role_name', 'Administrator')->first();
        $roleManager = \App\Models\Role::where('role_name', 'Manajer')->first();
        $roleUser = \App\Models\Role::where('role_name', 'User')->first();

        // Assigning roles to specific users
        $user1 = \App\Models\User::where('username', 'smartsoft')->first();  
        $user2 = \App\Models\User::where('username', 'smartsoft2')->first(); 
        $user3 = \App\Models\User::where('username', 'user')->first();

        // Assign 'Administrator' role to user1
        $this->createData($user1, $roleAdmin, $admin);

        // Assign 'Manajer' role to user2
        $this->createData($user2, $roleManager, $admin);

        // Assign 'User' role to user3
        $this->createData($user3, $roleUser, $admin);
    }

    public function createData($user, $role, $admin): void
    {
        \App\Models\UserRole::create([
            "user_id" => $user->user_id,
            "role_id" => $role->role_id,
            "created_by" => $admin->user_id,
            "updated_by" => $admin->user_id,
        ]);
    }
}
