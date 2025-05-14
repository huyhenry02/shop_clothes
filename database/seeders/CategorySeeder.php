<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use JsonException;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws JsonException
     */
    public function run(): void
    {
        $path = database_path('seeders/data/categories.csv');
        $csvData = array_map('str_getcsv', file($path));
        $categories = [];
        foreach ($csvData as $row) {
            $categories[] = [
                'id' => $row[0],
                'code' => $row[1],
                'name' => $row[2],
                'description' => $row[3],
                'sizes' => $row[4],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('categories')->insert($categories);
    }
}
