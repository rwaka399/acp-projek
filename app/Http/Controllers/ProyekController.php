<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\MenuMaster;
use App\Models\Proyek;
use App\Services\ProyekService;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexProyek()
    {
        $user = Session::get('user');
        $roleId = $user->userRole->first()->role_id; 

        
        $menus = MenuMaster::where('menu_master_parent', 0) 
            ->whereHas('roleMenu', function ($query) use ($roleId) {
                $query->where('role_menus.role_id', $roleId); 
            })
            ->with(['submenus' => function ($query) use ($roleId) {
                $query->whereHas('roleMenu', function ($permissionQuery) use ($roleId) {
                    $permissionQuery->where('role_menus.role_id', $roleId);
                });
            }])
            ->get();


        $data = ProyekService::dataAll();

        return view('proyek.index', ['data' => $data, 'menus' => $menus]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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

        return view('proyek.create' , ['menus' => $menus]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = [
            'proyek_name' => $request->input('proyek_name'),
            'proyek_description' => $request->input('proyek_description'),
        ];

        $validate = Validator::make($payload, [
            'proyek_name' => 'required|string',
            'proyek_description' => 'required',
        ], [
            'required' => ':attribute harus diisi',
            'string' => ':attribute harus berupa string',
        ], [
            'proyek_name' => 'Nama Proyek',
            'proyek_description' => 'Deskripsi Proyek',
        ]);

        if ($validate->fails()) {
            return ResponseFormatter::error([
                'error' => $validate->errors()->all(),
            ], 'validation failed', 402);
        }

        $data = ProyekService::create($payload);
        if (!$data['status']) {
            return ResponseFormatter::error($data['errors'], 'create data unsuccessful');
        }


        return redirect()->route('indexProyek');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Session::get('user');
        $roleId = $user->userRole->first()->role_id; // Ambil role_id dari user

        // Ambil menu utama berdasarkan role_id
        $menus = MenuMaster::where('menu_master_parent', 0) // Menu utama (parent)
            ->whereHas('roleMenu', function ($query) use ($roleId) {
                $query->where('role_menus.role_id', $roleId); // Menyaring menu berdasarkan role_id
            })
            ->with(['submenus' => function ($query) use ($roleId) {
                $query->whereHas('roleMenu', function ($permissionQuery) use ($roleId) {
                    $permissionQuery->where('role_menus.role_id', $roleId); //Menyaring submenu berdasarkan role_id
                });
            }])
            ->get();


        $data = ProyekService::getById($id);
        if(!$data['status']) {
            $errorCode = $data['errors'] == 'Not Found' ? 404 : 400;
            return ResponseFormatter::error([
                'errors' => $data['errors'],
            ], 'get data unsuccessful', $errorCode);
        }

        return view('proyek.show', ['data' => $data['data'], 'menus' => $menus]);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payload = [
            'proyek_name' => $request->input('proyek_name'),
            'proyek_description' => $request->input('proyek_description'),
        ];

        $validate = Validator::make($payload, [
            'proyek_name' => 'required|string',
            'proyek_description' => 'required',
        ], [
            'required' => ':attribute harus diisi',
            'string' => ':attribute harus berupa string',
        ], [
            'proyek_name' => 'Nama Proyek',
            'proyek_description' => 'Deskripsi Proyek',
        ]);

        if ($validate->fails()) {
            return ResponseFormatter::error([
                'error' => $validate->errors()->all(),
            ], 'validation failed', 402);
        }

        $data = ProyekService::update($payload, $id);
        if (!$data['status']) {
            return ResponseFormatter::error($data['errors'], 'update data unsuccessful');
        }

        return redirect()->route('indexProyek');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ProyekService::delete($id);
        if(!$data['status']) {
            return ResponseFormatter::error($data['errors'], 'delete data unsuccessful');
        }

        return redirect()->route('indexProyek');
    }

}
