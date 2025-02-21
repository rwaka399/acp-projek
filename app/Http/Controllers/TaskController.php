<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\MenuMaster;
use App\Models\Proyek;
use App\Models\Task;
use App\Services\ProyekService;
use App\Services\TaskService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexTask()
    {

        $user = Session::get('user');
        $roleId = $user->userRole->first()->role_id;

        // $taskId = Task::with('userTask')->get();

        $data_task = TaskService::getUserTasks($user->user_id);


        // Ambil menu utama berdasarkan role_id
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


            
        // $notifications = $this->checkNotifications($data_task);

        // $notifications = $this->checkNotifications($data_task);

        return view('task.index', [
            'data_task' => $data_task,
            // 'taskId'  => $taskId,
            'menus' => $menus,
            // 'notifications' => $notifications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $data_proyek = ProyekService::dataAll();

        $user = Session::get('user');
        $roleId = $user->userRole->first()->role_id;

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

        return view('task.create', [
            'data_proyek' => $data_proyek,
            'menus' => $menus,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = [
            'task_name' => $request->input('task_name'),
            'status' => $request->input('status'),
            'proyek' => $request->input('proyek'),
            'priority' => $request->input('priority'),
            'due_date' => $request->input('due_date'),
            'end_time' => $request->input('end_time'),
            'proses' => $request->input('proses'),
        ];

        $validate = Validator::make($payload, [
            'task_name'     => 'required|string',
            'status' => 'required',
            'proyek' => 'required|exists:proyeks,proyek_id',  // memastikan proyek valid dari database
            'priority' => 'required',
            'due_date' => 'nullable|date_format:Y-m-d',
            'end_time' => 'nullable|date_format:H:i',
            'proses' => 'required|integer|min:0|max:100',
        ], [
            'required' => ':attribute harus diisi',
            'date_format' => ':attribute harus berformat :format',
            'string' => ':attribute harus berupa string',
            'integer' => ':attribute harus berupa angka',
            'min' => ':attribute minimal :min',
            'max' => ':attribute maksimal :max',
        ], [
            'task_name' => 'Nama Task',
            'status' => 'Status Task',
            'proyek' => 'Proyek Task',
            'priority' => 'Prioritas Task',
            'proses' => 'Proses Task',
            'due_date' => 'Tanggal Deadline Task',
            'end_time' => 'Waktu Selesai Task',
        ]);

        

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->errors(),
            ], 400);
        }

        $data = TaskService::create($payload);

        if (!$data['status']) {
            return ResponseFormatter::error($data['errors'], 'create data unsuccessful');
        }

        return redirect()->route('indexTask');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Session::get('user');
        $roleId = $user->userRole->first()->role_id;

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


        $data = TaskService::getById($id);
        $data_proyek_selected = ProyekService::getByTaskId($id);
        $data_proyek = ProyekService::dataAll();

        // dd($data_proyek_selected['data']);

        if (!$data['status']) {
            $errorCode = $data['message'] == 'Not Found' ? 404 : 400;
            return response()->json([
                'status' => false,
                'message' => $data['message'],
            ], $errorCode);
        }

        return view('task.show', [
            'data' => $data[
                'data'
            ],
            'data_proyek' => $data_proyek,
            'menus' => $menus,
            'data_proyek_selected' => $data_proyek_selected['data'],
        ]);
    }




    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Request $request, string $id)
    // {

    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payload = [
            'task_name' => $request->input('task_name'),
            'status' => $request->input('status'),
            'proyek' => $request->input('proyek'),
            'priority' => $request->input('priority'),
            'proses' => $request->input('proses', 0),
            'due_date' => $request->input('due_date'),
            'end_time' => $request->input('end_time'),
        ];

        $validate = Validator::make($payload, [
            'task_name' => 'required|string',
            'status' => 'required',
            'proyek' => 'required|exists:proyeks,proyek_id',  
            'priority' => 'required',
            'proses' => 'required|integer|min:0|max:100',
            'due_date' => 'nullable|date_format:Y-m-d',
            'end_time' => 'nullable',
        ], [
            'required' => ':attribute harus diisi',
            'string' => ':attribute harus berupa string',
            'date_format' => ':attribute harus berformat :format',
            'integer' => ':attribute harus berupa angka',
            'min' => ':attribute minimal :min',
            'max' => ':attribute maksimal :max',
        ], [
            'task_name' => 'Nama Task',
            'status' => 'Status Task',
            'proyek' => 'Proyek Task',
            'priority' => 'Prioritas Task',
            'proses' => 'Proses Task',
            'due_date' => 'Tanggal Deadline Task',
        ]);


        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->errors(),
            ], 400);
        }

        $data = TaskService::update($payload, $id);
        if (!$data['status']) {
            return ResponseFormatter::error($data['errors'], 'update data unsuccessful');
        }

        return redirect()->route('indexTask')->with('success', 'Task berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = TaskService::delete($id);
        if (!$data['status']) {
            $errorCode = $data['errors'] == 'Not Found' ? 404 : 400;
            return ResponseFormatter::error([
                'errors' => $data['errors'],
            ], 'delete data unsuccessful', $errorCode);
        }

        return redirect()->route('indexTask');   
    }
}
