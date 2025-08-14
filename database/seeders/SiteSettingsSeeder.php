<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_settings')->insert([
            'site_name' => 'AMS',
            'tagline' => 'AMS Store',
            'meta_title' => 'AMS - Home',
            'meta_description' => 'Welcome to AMS.',
            'meta_keywords' => 'ams, store, ecommerce',
            'logo' => 'img/logoams.png',
            'favicon' => 'favicon.ico',
            'contact_email' => 'info@ams-indo.com',
            'contact_phone' => '+62816717942',
            'address' => 'Jl.Nusantara IX, Blok HK Perum.BDB 2 No.03 Sukahati, Kec. Cibinong, Kabupaten Bogor Jawa Barat 16913, Indonesia',
            'footer_text' => '© ' . date('Y') . ' PT. Anugerah Mitrautama Sejahtera. All rights reserved.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
