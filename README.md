# Proyek Anugerah - Sistem Katalog Produk & CMS

Aplikasi web berbasis Laravel yang berfungsi sebagai katalog produk dan sistem manajemen konten (CMS). Fokus utama aplikasi ini adalah untuk menampilkan produk-produk (khususnya di bidang alat kesehatan) dan memungkinkan pengunjung untuk meminta penawaran langsung melalui WhatsApp.

Aplikasi ini juga dilengkapi dengan panel admin yang komprehensif untuk mengelola seluruh konten situs, mulai dari produk, kategori, blog, hingga halaman statis.

## Fitur Utama

### Frontend (Sisi Pengunjung)
- **Katalog Produk**: Menampilkan daftar produk dengan filter berdasarkan kategori.
- **Halaman Detail Produk**: Halaman lengkap untuk setiap produk, termasuk galeri gambar, deskripsi singkat, dan deskripsi lengkap.
- **Permintaan Penawaran via WhatsApp**: Tombol "Minta Penawaran" yang mengarahkan pengguna ke WhatsApp dengan pesan yang sudah diisi sebelumnya.
- **Blog**: Bagian untuk artikel, berita, atau pembaruan terkait perusahaan.
- **Halaman Statis**: Halaman yang dapat dikelola dari admin panel seperti "Tentang Kami", "Layanan", dan "Kontak".
- **Desain Responsif**: Tampilan yang beradaptasi dengan baik di berbagai perangkat (desktop, tablet, mobile).

### Backend (Panel Admin)
- **Dashboard**: Halaman utama admin yang memberikan ringkasan informasi penting.
- **Manajemen Produk**: Operasi CRUD (Create, Read, Update, Delete) untuk produk.
- **Manajemen Kategori**: CRUD untuk kategori produk, mendukung struktur induk-anak (subkategori).
- **Manajemen Merek**: CRUD untuk merek produk.
- **Manajemen Pesanan**: Melihat detail pesanan atau permintaan penawaran yang masuk.
- **Manajemen Blog**: CRUD untuk artikel blog.
- **Manajemen Halaman**: CRUD untuk halaman statis.
- **Manajemen Menu**: Mengatur struktur menu navigasi utama situs.
- **Dukungan Multi-bahasa**: Mengelola konten dalam berbagai bahasa.
- **Pengaturan Situs**: Mengelola konfigurasi umum situs.

## Tumpukan Teknologi (Tech Stack)

- **Backend**: PHP 8.x, Laravel 10.x
- **Frontend**: Blade, HTML5, CSS3, JavaScript, jQuery, Bootstrap
- **Database**: MySQL / MariaDB
- **Server Development**: Laragon (atau sejenisnya seperti XAMPP, WAMP)
- **Paket Utama**:
  - `yajra/laravel-datatables-oracle`: Untuk tabel data yang interaktif di panel admin.

## Panduan Instalasi Lokal

Berikut adalah langkah-langkah untuk menginstal dan menjalankan proyek ini di lingkungan pengembangan lokal Anda.

1.  **Clone Repositori**
    ```bash
    git clone [URL_REPOSITORI_ANDA]
    cd anugerah
    ```

2.  **Install Dependensi**
    Install dependensi PHP dengan Composer dan dependensi JavaScript dengan NPM.
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    # Untuk Windows
    copy .env.example .env

    # Untuk Linux/macOS
    cp .env.example .env
    ```

4.  **Generate Kunci Aplikasi**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan pengaturan database sesuai dengan konfigurasi lokal Anda.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=anugerah
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Jalankan Migrasi & Seeder**
    Buat struktur tabel dan isi data awal (jika ada).
    ```bash
    php artisan migrate --seed
    ```

7.  **Buat Symbolic Link untuk Storage**
    Agar file yang diunggah (seperti gambar produk) dapat diakses dari web.
    ```bash
    php artisan storage:link
    ```

8.  **Kompilasi Aset Frontend**
    ```bash
    npm run dev
    ```

9.  **Jalankan Server**
    Anda bisa menggunakan server development bawaan Artisan atau mengaksesnya melalui Virtual Host yang dikonfigurasi di Laragon.
    ```bash
    php artisan serve
    ```
    Aplikasi akan berjalan di `http://127.0.0.1:8000`.

## Akses Panel Admin

- **URL Login**: `http://127.0.0.1:8000/login`
- **Akun Default**:
  - **Email**: `admin@example.com`
  - **Password**: `password`

> **Catatan**: Akun admin default harus dibuat terlebih dahulu. Pastikan Anda memiliki `UserSeeder` yang membuat akun ini atau buat secara manual melalui registrasi (jika diaktifkan) atau Tinker.

## Rute Penting

- **Halaman Utama**: `/`
- **Katalog Produk**: `/shop`
- **Blog**: `/blog`
- **Login Admin**: `/login`
- **Dashboard Admin**: `/admin/dashboard`

---
