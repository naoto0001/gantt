<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use App\Models\Gant;
use Illuminate\Support\Facades\DB;

class GanttSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gant::truncate(); 

        for ($i = 1; $i <= 10; $i++) {
            DB::table('gantt')->insert([
                'name' => '作業名' . $i,
                'start' => date('Y-m-d', strtotime('2024-07-01 + ' . rand(0, 30) . ' days')),
                'end' => date('Y-m-d', strtotime('2024-08-01 + ' . rand(0, 30) . ' days')),
                'client' => '依頼者' . $i,
                'parts' => '部品' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
