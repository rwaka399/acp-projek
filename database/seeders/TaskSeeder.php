<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::first();
        Task::create([
            'task_name' => 'Design UI Mockups',
            'status' => 'in-progress',
            'priority' => 'high',
            'proses' => 50, // persen progress
            'due_date' => '2024-12-01',
            'end_time' => '17:00:00',
            'created_by' => $admin->user_id,
        ]);

        Task::create([
            'task_name' => 'Develop Backend API',
            'status' => 'pending',
            'priority' => 'medium',
            'proses' => 0,
            'due_date' => '2024-12-05',
            'end_time' => '18:00:00',
            'created_by' => $admin->user_id,
        ]);

        Task::create([
            'task_name' => 'Create Test Cases',
            'status' => 'completed',
            'priority' => 'low',
            'proses' => 100,
            'due_date' => '2024-11-15',
            'end_time' => '12:00:00',
            'created_by' => $admin->user_id,
        ]);

        
    }
}
