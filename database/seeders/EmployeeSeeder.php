<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/employees.csv');
        $csvData = array_map('str_getcsv', file($path));
        $employees = [];
        foreach ($csvData as $row) {
            $employees[] = [
                'id' => $row[0],
                'user_id' => $row[1],
                'full_name' => $row[2],
                'phone' => $row[3],
                'position' => $row[4],
                'address' => $row[5],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('employees')->insert($employees);
    }
}
