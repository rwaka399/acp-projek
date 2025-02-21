<?php

namespace App\Http\Controllers;

use App\Models\MenuMaster;
use App\Models\Task;
use App\Models\User;
use App\Services\Master\MenuMasterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ViewController extends Controller
{
    public function dashboard()
    {
        // Ambil data user dari session
        $user = Session::get('user');
        $roleId = $user->userRole->first()->role_id; // Ambil role_id dari user
        $userId = $user->user_id;

        // Ambil menu utama berdasarkan role_id
        $menus = MenuMaster::where('menu_master_parent', 0) // Menu utama (parent)
            ->whereHas('roleMenu', function ($query) use ($roleId) {
                $query->where('role_menus.role_id', $roleId); // Menyaring menu berdasarkan role_id
            })
            ->with(['submenus' => function ($query) use ($roleId) {
                $query->whereHas('roleMenu', function ($permissionQuery) use ($roleId) {
                    $permissionQuery->where('role_menus.role_id', $roleId); // Menyaring submenu berdasarkan role_id
                });
            }])
            ->get();

        // Menghitung jumlah task berdasarkan status dan user_id
        $count['completed'] = $user->tasks()->where('status', 'Completed')->count();
        $count['progress'] = $user->tasks()->where('status', 'In Progress')->count();
        $count['hold'] = $user->tasks()->where('status', 'Hold')->count();


        return view('dashboard', compact('menus', 'count'));
    }
}
