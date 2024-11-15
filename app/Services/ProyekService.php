<?php

namespace App\Services;

use App\Models\Proyek;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProyekService
{
    public static function dataAll()
    {
        return Proyek::all();
    }



    public static function getById($id)
    {
        try {
            $data = Proyek::find($id);
            if (!$data) {
                return [
                    'status' => false,
                    'data' => "Not Found"
                ];
            }
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'errors' => $th->getMessage()
            ];
        }
    }
    public static function getByTaskId($id)
    {
        try {
            $data = Proyek::join('task_proyeks', 'proyeks.proyek_id', '=', 'task_proyeks.proyek_id')
                ->where('task_proyeks.task_id', $id)
            ->first();
            if (!$data) {
                return [
                    'status' => false,
                    'data' => "Not Found"
                ];
            }
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'errors' => $th->getMessage()
            ];
        }
    }

    public static function create(array $payload): array
    {
        DB::beginTransaction();
        try {
            $data = Proyek::create([
                'proyek_name' => $payload['proyek_name'],
                'proyek_description' => $payload['proyek_description'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => false,
                'errors' => $th->getMessage()
            ];
        }
    }


    public static function update($payload, $id)
    {
        DB::beginTransaction();
        try {
            $data = Proyek::where('proyek_id', $id)->first();
            if (empty($data)) {
                return [
                    'status' => false,
                    'message' => 'Not Found'
                ];
            } else {
                $data->update([
                    'proyek_name' => $payload['proyek_name'],
                    'proyek_description' => $payload['proyek_description'],
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                DB::commit();
                return [
                    'status' => true,
                    'data' => $data
                ];
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => false,
                'errors' => $th->getMessage()
            ];
        }
    }

    public static function delete($id)
    {
        DB::beginTransaction();
        try {
            $data = Proyek::where('proyek_id', $id)->first();
            if(empty($data)){
                return [
                    'status' => false,
                    'errors' => "Not Found"
                ];
            }
            $data->delete();

            DB::commit();
            return [
                'status' => true,
                'data' => true
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'status' => false,
                'errors' => $th->getMessage()
            ];
        }
    }
}
