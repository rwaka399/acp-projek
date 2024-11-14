<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Proyek;
use App\Models\Task;
use App\Services\ProyekService;
use App\Services\TaskService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_task = TaskService::dataAll()->get();

        $notifications = $this->checkNotifications($data_task);

        return view('task.index', [
            'data_task' => $data_task,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_proyek = ProyekService::dataAll();

        return view('task.create', [
            'data_proyek' => $data_proyek,
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

        return redirect()->route('task.all');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = TaskService::getById($id);
        $data_proyek = ProyekService::dataAll();

        if (!$data['status']) {
            $errorCode = $data['message'] == 'Not Found' ? 404 : 400;
            return response()->json([
                'status' => false,
                'message' => $data['message'],
            ], $errorCode);
        }

        // Ambil ID proyek yang terkait dengan task
        $selectedProyeks = $data['data']->proyek->pluck('proyek_id')->toArray();

        return view('task.show', [
            'data' => $data['data'],
            'data_proyek' => $data_proyek,
            'selectedProyeks' => $selectedProyeks,
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
        ];

        $validate = Validator::make($payload, [
            'task_name' => 'required|string',
            'status' => 'required',
            'proyek' => 'required|exists:proyeks,proyek_id',  // memastikan proyek valid dari database
            'priority' => 'required',
            'proses' => 'required|integer|min:0|max:100',
            'due_date' => 'required|date_format:Y-m-d',
            'end_time' => 'nullable|date_format:H:i',
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $data = TaskService::delete($task);
        if (!$data['status']) {
            $errorCode = $data['errors'] == 'Not Found' ? 404 : 400;
            return ResponseFormatter::error([
                'errors' => $data['errors'],
            ], 'delete data unsuccessful', $errorCode);
        }
    }
}
