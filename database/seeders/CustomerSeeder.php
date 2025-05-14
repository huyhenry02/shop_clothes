<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/customers.csv');
        $csvData = array_map('str_getcsv', file($path));
        $customers = [];
        foreach ($csvData as $row) {
            $customers[] = [
                'id' => $row[0],
                'user_id' => $row[1],
                'full_name' => $row[2],
                'phone' => $row[3],
                'address' => $row[4],
                'gender' => $row[5],
                'birthday' => $row[6],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('customers')->insert($customers);
    }
}
