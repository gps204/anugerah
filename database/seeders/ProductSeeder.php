<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Nurse Call Commax CL-302I',
                'category_id' => 1, // Sesuaikan dengan ID kategori yang ada
                'brand_id' => 1,    // Sesuaikan dengan ID brand yang ada
                'description' => 'Sistem panggilan perawat handal dari Commax untuk efisiensi rumah sakit.',
            ],
            [
                'name' => 'Bedside Cabinet Z-01',
                'category_id' => 2, // Sesuaikan dengan ID kategori yang ada
                'brand_id' => 2,    // Sesuaikan dengan ID brand yang ada
                'description' => 'Lemari samping tempat tidur pasien dengan desain modern dan fungsional.',
            ],
            [
                'name' => 'Central Gas Medis System',
                'category_id' => 3, // Sesuaikan dengan ID kategori yang ada
                'brand_id' => 1,    // Sesuaikan dengan ID brand yang ada
                'description' => 'Sistem instalasi gas medis terpusat untuk kebutuhan rumah sakit.',
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'shop_id' => 1,
                'vendor_id' => 1,
                'slug' => Str::slug($productData['name']),
                'category_id' => $productData['category_id'],
                'brand_id' => $productData['brand_id'],
                'product_type' => 'simple',
                'status' => 1,
            ]);

            ProductTranslation::create([
                'product_id' => $product->id,
                'language_code' => 'id',
                'name' => $productData['name'],
                'description' => $productData['description'],
                'short_description' => Str::limit($productData['description'], 150),
            ]);
        }
    }
}
