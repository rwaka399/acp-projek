<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::first();
        \App\Models\Proyek::create([
            'proyek_name' => "Proyek 1",
            'proyek_description' => 'Proyek ini bertindak sebagai Proyek 1.',
            'created_by' => $admin->user_id,
            'updated_by' => $admin->user_id,
        ]);
        \App\Models\Proyek::create([
            'proyek_name' => "Proyek 2",
            'proyek_description' => 'Proyek ini bertindak sebagai Proyek 2.',
            'created_by' => $admin->user_id,
            'updated_by' => $admin->user_id,
        ]);
        \App\Models\Proyek::create([
            'proyek_name' => "Proyek 3",
            'proyek_description' => 'Proyek ini bertindak sebagai Proyek 3.',
            'created_by' => $admin->user_id,
            'updated_by' => $admin->user_id,
        ]);
    }
}
