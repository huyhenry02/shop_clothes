<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        file tổng để gọi đến các file seerder khác
//        chạy lệnh php artisan db:seed để thực thi các file seeder dưới
        $this->call(
            [
                UserSeeder::class,
                CustomerSeeder::class,
                EmployeeSeeder::class,
                CategorySeeder::class,
                ProductSeeder::class,
            ]
        );
    }
}
