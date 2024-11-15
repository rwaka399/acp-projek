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
        // Ambil data user dari session
        $user = Session::get('user');
        $roleId = $user->userRole->first()->role_id; // Ambil role_id dari user

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



        // $menus = MenuMasterService::getAllPaginate();
        // $user = Auth::user();
        // $roleId = $user->role->role_id; // Assuming you have a `role` relationship on the User model

        // // Get top-level menus the user has access to
        // $menus = MenuMaster::where('menu_master_parent', 0)
        //     ->with(['submenus' => function ($query) use ($roleId) {
        //         $query->whereHas('permissions', function ($permissionQuery) use ($roleId) {
        //             $permissionQuery->where('role_id', $roleId)
        //                 ->where('value', true); // Only show menus with true permissions
        //         });
        //     }])
        //     ->get();

        $count['completed'] = Task::where('status', '=', 'Completed')->count();
        $count['progres'] = Task::where('status', '=', 'In Progress')->count();
        $count['hold'] = Task::where('status', '=', 'Hold')->count();

        $count['user'] = User::all()->count();



        // return view('dashboard', $count);


        return view('dashboard', compact('menus'), $count);
    }
}
