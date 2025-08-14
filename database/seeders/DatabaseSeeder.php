<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Data dasar yang tidak memiliki dependensi
            LanguageSeeder::class,
            SiteSettingsSeeder::class,
            // Data yang dibutuhkan oleh User dan Produk
            ShopVendorSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            // Data Produk yang bergantung pada kategori, brand, dll.
            ProductSeeder::class,
            // Data Order yang bergantung pada Produk
            OrderSeeder::class,
        ]);
    }
}
