<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop ASUS ROG',
                'description' => 'Laptop gaming dengan performa tinggi',
                'price' => 15000000,
                'stock_quantity' => 5,
                'category_id' => 1
            ],
            [
                'name' => 'Smartphone Samsung Galaxy',
                'description' => 'Smartphone Android terbaru',
                'price' => 5000000,
                'stock_quantity' => 15,
                'category_id' => 1
            ],
            [
                'name' => 'Kaos Polos Premium',
                'description' => 'Kaos polos berkualitas tinggi',
                'price' => 150000,
                'stock_quantity' => 50,
                'category_id' => 2
            ],
            [
                'name' => 'Celana Jeans Slim Fit',
                'description' => 'Celana jeans dengan model slim fit',
                'price' => 350000,
                'stock_quantity' => 25,
                'category_id' => 2
            ],
            [
                'name' => 'Snack Keripik Kentang',
                'description' => 'Keripik kentang berbagai rasa',
                'price' => 15000,
                'stock_quantity' => 100,
                'category_id' => 3
            ],
            [
                'name' => 'Minuman Energi',
                'description' => 'Minuman energi untuk stamina',
                'price' => 25000,
                'stock_quantity' => 75,
                'category_id' => 3
            ],
            [
                'name' => 'Buku Programming Laravel',
                'description' => 'Buku panduan lengkap Laravel',
                'price' => 200000,
                'stock_quantity' => 10,
                'category_id' => 4
            ],
            [
                'name' => 'Novel Best Seller',
                'description' => 'Novel terpopuler saat ini',
                'price' => 85000,
                'stock_quantity' => 30,
                'category_id' => 4
            ],
            [
                'name' => 'Dumbell Set 10kg',
                'description' => 'Set dumbell untuk latihan beban',
                'price' => 500000,
                'stock_quantity' => 8,
                'category_id' => 5
            ],
            [
                'name' => 'Matras Yoga',
                'description' => 'Matras yoga anti slip',
                'price' => 120000,
                'stock_quantity' => 20,
                'category_id' => 5
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 