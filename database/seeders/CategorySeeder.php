<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Produk-produk elektronik seperti laptop, smartphone, dll'
            ],
            [
                'name' => 'Pakaian',
                'description' => 'Berbagai jenis pakaian pria dan wanita'
            ],
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Produk makanan dan minuman'
            ],
            [
                'name' => 'Buku',
                'description' => 'Berbagai jenis buku dan literatur'
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Perlengkapan olahraga dan fitness'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
