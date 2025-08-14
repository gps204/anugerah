<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Shop;
use App\Models\Vendor;

class ShopVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Buat Vendor default terlebih dahulu karena Shop bergantung padanya.
            // Juga, tambahkan password default karena kolom ini wajib diisi.
            $vendor = Vendor::firstOrCreate(
                ['id' => 1],
                [
                    'name' => 'Vendor Utama',
                    'email' => 'vendor@anugerah.com',
                    'password' => Hash::make('password'), // Tambahkan password default
                    'phone' => '081234567890',
                    'status' => 'active',
                ]
            );

            // 2. Buat Shop default dan hubungkan dengan vendor yang baru dibuat.
            $shop = Shop::firstOrCreate(
                ['id' => 1],
                [
                    'vendor_id' => $vendor->id, // Hubungkan ke vendor
                    'name' => 'Toko Anugerah Utama',
                    'slug' => 'toko-anugerah-utama',
                    'status' => 'active',
                ]
            );

            // 3. Hubungkan user pertama yang ada dengan Shop dan Vendor default.
            // Pastikan Anda sudah punya user (misal: admin)
            $user = User::first();
            if ($user) {
                $user->shop_id = $shop->id;
                $user->vendor_id = $vendor->id;
                $user->save();
            }
        });

        $this->command->info('Default shop, vendor, and user links have been set up successfully.');
    }
}