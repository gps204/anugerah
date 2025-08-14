@extends('themes.xylo.layouts.master')

@section('content')

<!-- Page Title Section -->
<section class="page-title-section py-5 bg-light">
    <div class="container text-center">
        <h1 class="display-4 fw-bold" style="color: #3e71a8;">Layanan Unggulan Kami</h1>
        <p class="lead text-muted">Solusi teknologi medis terintegrasi untuk meningkatkan efisiensi dan kualitas pelayanan kesehatan.</p>
    </div>
</section>

<!-- Services Section -->
<section class="service-section py-5">
    <div class="container">
        <div class="row">
            <!-- Service 1: Nursecall System -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <i class="fa fa-medkit"></i>
                    <h3>Sistem Panggil Perawat (Nursecall System)</h3>
                    <p>Instalasi dan pemeliharaan sistem panggilan perawat yang andal dan modern untuk memastikan respons cepat terhadap kebutuhan pasien.</p>
                </div>
            </div>

            <!-- Service 2: Gas Medis -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <i class="fa fa-fire"></i>
                    <h3>Instalasi Gas Medis</h3>
                    <p>Pemasangan sistem gas medis yang aman, efisien, dan sesuai standar untuk mendukung operasional fasilitas kesehatan Anda.</p>
                </div>
            </div>

            <!-- Service 3: SIM RS -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <i class="fa fa-hospital"></i>
                    <h3>Sistem Informasi Rumah Sakit (SIMRS)</h3>
                    <p>Pengembangan dan implementasi Sistem Informasi Rumah Sakit (SIMRS) yang terintegrasi untuk manajemen data yang lebih baik.</p>
                </div>
            </div>

            <!-- Service 4: Fire Alarm System -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <i class="fa fa-bell"></i>
                    <h3>Sistem Alarm Kebakaran</h3>
                    <p>Menyediakan solusi sistem alarm kebakaran yang canggih untuk proteksi maksimal aset dan keselamatan jiwa di fasilitas Anda.</p>
                </div>
            </div>

            <!-- Service 5: Maintenance & Support -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <i class="fa fa-cogs"></i>
                    <h3>Pemeliharaan & Dukungan Teknis</h3>
                    <p>Layanan pemeliharaan preventif dan dukungan teknis responsif untuk memastikan semua sistem berjalan optimal.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection