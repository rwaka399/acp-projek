<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskProyek;
use App\Models\UserTask;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TaskService
{

    public static function dataAll()
    {
        return Task::query();
    }

    public static function getUserTasks($userId)
    {
        return Task::whereHas('userTask', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('userTask')->get();
    }

    public static function create($payload)
    {

        DB::beginTransaction();
        try {

            $user = Session::get('user');

            $task = Task::create([
                'task_name' => $payload['task_name'],
                'status' => $payload['status'],
                'priority' => $payload['priority'],
                'proses' => $payload['proses'],
                'due_date' => $payload['due_date'],
                'end_time' => $payload['end_time'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => $user->user_id,
            ]);

            
            UserTask::create([
                'user_id' => $user->user_id, // User yang membuat atau menerima task
                'task_id' => $task->task_id,
                'created_by' => $user->user_id,
            ]);
    

            if ($payload['proyek']) {
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
            $data = Task::with('taskProyek.proyek')->where('task_id', $id)->first();
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

            $user = Session::get('user');

            $data = Task::where('task_id', $id)->first();
            if (empty($data)) {
                return [
                    'status' => false,
                    'errors' => "not found",
                ];
            } else {
                $data->update([
                    'task_name' => $payload['task_name'],
                    'due_date' => $payload['due_date'],
                    'status' => $payload['status'],
                    'proses' => $payload['proses'],
                    'end_time' => $payload['end_time'],
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'update_by' => $user->user_id,
                ]);


                if ($payload['proyek']) {
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
