<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = \App\Models\MenuMaster::all();
        // $adminRole = \App\Models\Role::where("role_name", "Administrator")->first();
        // $userRole = \App\Models\Role::where("role_name", "User")->first();
        $roles = \App\Models\Role::all();
        $admin = \App\Models\User::first();

        foreach ($roles as $role) {
            foreach ($menus as $menu) {
                if ($role->role_name == 'Administrator') {
                    \App\Models\RoleMenu::create([
                        'role_id' => $role->role_id,
                        'menu_master_id' => $menu->menu_master_id,
                        'created_by' => $admin->user_id,
                    ]);
                }

                elseif (
                    $role->role_name == 'Manajer' &&
                    ($menu->menu_master_name == 'Dashboards' || $menu->menu_master_name == 'Task' || $menu->menu_master_name == 'Master' ||($menu->menu_master_name == 'Proyek' && $menu->menu_master_parent == 2) || $menu->menu_master_name == 'Logout')
                ) {
                    \App\Models\RoleMenu::create([
                        'role_id' => $role->role_id,
                        'menu_master_id' => $menu->menu_master_id,
                        'created_by' => $admin->user_id,
                    ]);
                }
                
                elseif (
                    $role->role_name == 'User' &&
                    in_array($menu->menu_master_name, ['Dashboards', 'Task', 'Logout'])
                ) {
                    \App\Models\RoleMenu::create([
                        'role_id' => $role->role_id,
                        'menu_master_id' => $menu->menu_master_id,
                        'created_by' => $admin->user_id,
                    ]);
                } 
                
            }
        }
    }
}
