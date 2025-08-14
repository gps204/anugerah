<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada produk untuk dikaitkan dengan pesanan
        $product = Product::first();

        // Jika tidak ada produk, jangan jalankan seeder ini.
        if (!$product) {
            $this->command->info('No products found, skipping OrderSeeder.');
            return;
        }

        // Buat satu pesanan sederhana dengan total awal 0
        $order = Order::create([
            'customer_id' => null, // Pesanan sebagai tamu
            'guest_email' => 'guest@example.com',
            'total_amount' => 0, // Akan diupdate setelah detail ditambahkan
            'status' => 'completed',
        ]);

        // Tambahkan detail pesanan (rincian produk)
        $quantity = 2;
        $price = 75000.00; // Harga contoh untuk produk ini
        $totalAmount = $quantity * $price;

        DB::table('order_details')->insert([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update total_amount di pesanan utama agar sesuai dengan detailnya
        $order->total_amount = $totalAmount;
        $order->save();
    }
}
