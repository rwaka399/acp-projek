<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskProyek;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskService
{

    public static function dataAll()
    {
        return Task::all();
    }

    public static function create($payload)
    {

        DB::beginTransaction();
        try {
            $task = Task::create([
                'task_name' => $payload['task_name'],
                'task_description' => $payload['task_description'],
                'status' => $payload['status'],
                'priority' => $payload['priority'],
                'proses' => $payload['proses'],
                'due_date' => $payload['due_date'],
                'end_time' => $payload['end_time'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                // 'created_by' => Auth::user()->user_id,
            ]);

            if($payload['proyek']){
                TaskProyek::create([
                    'task_id' => $task->task_id,
                    'proyek_id' => $payload['proyek']
                ]);
                
            }

            DB::commit();
            return [
                'status' => true,
                'data' => $task
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => false,
                'errors' => $th->getMessage()
            ];
        }
    }

    public static function getById($id)
    {
        try {
            $data = Task::find($id);
            if (!$data) {
                return [
                    'status' => false,
                    'message' => 'Not Found'
                ];
            }
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => $th->getMessage()
            ];
        }
    }

    public static function update($payload, $id)
    {
        DB::beginTransaction();
        try {
            $data = Task::where('task_id', $id)->first();
            if (empty($data)) {
                return [
                    'status' => false,
                    'errors' => "not found",
                ];
            } else {
                $data->update([
                    'task_name' => $payload['task_name'],
                    'task_description' => $payload['task_description'],
                    'due_date' => $payload['due_date'],
                    'status' => $payload['status'],
                    'presentase' => $payload['presentase'],
                    'end_time' => $payload['end_time'],
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    // 'update' => Auth::user()->user_id,
                ]);
                if($payload['proyek']){
                    TaskProyek::where('task_id', $id)->update([
                        'proyek_id' => $payload['proyek']
                    ]);
                }

                DB::commit();
                return [
                    'status' => true,
                    'data'   => $data,
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => false,
                'errors' => $th->getMessage(),
            ];
        }
    }

    public static function delete($id)
    {
        DB::beginTransaction();
        try {
            $data = Task::where('task_id', $id)->first();
            if (empty($data)) {
                return [
                    'status' => false,
                    'errors' => "not found",
                ];
            }
            $data->delete();

            DB::commit();
            return [
                'status' => true,
                'data'   => true,
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => false,
                'errors' => $th->getMessage(),
            ];
        }
    }
}