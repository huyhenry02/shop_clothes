<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/products.csv');
        $csvData = array_map('str_getcsv', file($path));
        $products = [];
        $imageMainMap = [
            1 => '/customer/images/products/cat_1_main.jpg',
            2 => '/customer/images/products/cat_2_main.jpg',
            3 => '/customer/images/products/cat_3_main.jpg',
            4 => '/customer/images/products/cat_4_main.jpg',
            5 => '/customer/images/products/cat_5_main.jpg',
            6 => '/customer/images/products/cat_6_main.jpg',
            7 => '/customer/images/products/cat_7_main.jpg',
            8 => '/customer/images/products/cat_8_main.jpg',
        ];
        $imageDetailMap = [
            1 => '/customer/images/products/cat_1_detail.jpg',
            2 => '/customer/images/products/cat_2_detail.jpg',
            3 => '/customer/images/products/cat_3_detail.jpg',
            4 => '/customer/images/products/cat_4_detail.jpg',
            5 => '/customer/images/products/cat_5_detail.jpg',
            6 => '/customer/images/products/cat_6_detail.jpg',
            7 => '/customer/images/products/cat_7_detail.jpg',
            8 => '/customer/images/products/cat_8_detail.jpg',
        ];
        $imageDetail2Map = [
            1 => '/customer/images/products/cat_1_detail_2.jpg',
            2 => '/customer/images/products/cat_2_detail_2.jpg',
            3 => '/customer/images/products/cat_3_detail_2.jpg',
            4 => '/customer/images/products/cat_4_detail_2.jpg',
            5 => '/customer/images/products/cat_5_detail_2.jpg',
            6 => '/customer/images/products/cat_6_detail_2.jpg',
            7 => '/customer/images/products/cat_7_detail_2.jpg',
            8 => '/customer/images/products/cat_8_detail_2.jpg',
        ];
        $imageDetail3Map = [
            1 => '/customer/images/products/cat_1_detail_3.jpg',
            2 => '/customer/images/products/cat_2_detail_3.jpg',
            3 => '/customer/images/products/cat_3_detail_3.jpg',
            4 => '/customer/images/products/cat_4_detail_3.jpg',
            5 => '/customer/images/products/cat_5_detail_3.jpg',
            6 => '/customer/images/products/cat_6_detail_3.jpg',
            7 => '/customer/images/products/cat_7_detail_3.jpg',
            8 => '/customer/images/products/cat_8_detail_3.jpg',
        ];
        foreach ($csvData as $row) {
            $categoryId = (int)$row[1];
            $image = $imageMainMap[$categoryId] ?? '/customer/images/products/default.jpg';
            $image_detail_1 = $imageDetailMap[$categoryId] ?? '/customer/images/products/default.jpg';
            $image_detail_2 = $imageDetail2Map[$categoryId] ?? '/customer/images/products/default.jpg';
            $image_detail_3 = $imageDetail3Map[$categoryId] ?? '/customer/images/products/default.jpg';
            $products[] = [
                'id' => $row[0],
                'category_id' => $row[1],
                'code' => $row[2],
                'name' => $row[3],
                'slug' => $row[4],
                'description' => $row[5],
                'price' => $row[6],
                'discount_price' => $row[7],
                'stock_quantity' => $row[8],
                'color' => $row[9],
                'material' => $row[10],
                'style' => $row[11],
                'is_active' => $row[12],
                'image' => $image,
                'image_detail_1' => $image_detail_1,
                'image_detail_2' => $image_detail_2,
                'image_detail_3' => $image_detail_3,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('products')->insert($products);
    }
}
