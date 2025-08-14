@extends('themes.xylo.layouts.master')

@section('css')
<style>
    .about-section, .vision-mission-section {
        padding: 60px 0;
    }
    .about-section {
        background-color: #fff;
    }
    .vision-mission-section {
        background-color: #f9f9f9;
    }
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #3e71a8;
        margin-bottom: 20px;
    }
    .section-subtitle {
        font-size: 1.5rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 30px;
    }
    .about-text p {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #666;
        margin-bottom: 20px;
    }
    .about-image img {
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .vision-mission-box {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        height: 100%;
    }
    .vision-mission-box h3 {
        color: #3e71a8;
        margin-bottom: 15px;
    }
    .vision-mission-box ul {
        padding-left: 20px;
    }
    .vision-mission-box ul li {
        margin-bottom: 10px;
        font-size: 1.05rem;
        color: #555;
    }
    .banner-area.inner-banner h1 {
        color: #3e71a8;
    }
</style>
@endsection

@section('content')
    <!-- Banner Section -->
    <section class="banner-area inner-banner">
        <div class="container">
            <h1 class="text-center">Tentang Kami</h1>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="text-center">
                        <h3 class="section-subtitle">Sertifikasi</h3>
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="about-image">
                                    <img src="{{ asset('img/gasmedis.webp') }}" alt="Sertifikasi Gas Medis">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="about-image">
                                    <img src="{{ asset('img/pelatihan.webp') }}" alt="Sertifikasi Pelatihan">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-text">
                        <h2 class="section-title text-center">PT. Anugerah Mitrautama Sejahtera</h2>
                        <h4 class="section-subtitle">Solusi Teknologi Medis Terdepan</h4>
                        <p>
                            PT. Anugerah Mitrautama Sejahtera (AMS) adalah perusahaan yang berdedikasi untuk menyediakan solusi teknologi medis terdepan bagi rumah sakit dan fasilitas kesehatan di seluruh Indonesia. Sejak didirikan, kami telah berkomitmen untuk meningkatkan kualitas layanan kesehatan melalui inovasi, keandalan, dan layanan pelanggan yang unggul.
                        </p>
                        <p>
                            Kami mengkhususkan diri dalam tiga bidang utama: Sistem Panggil Perawat (Nursecall System), Instalasi Gas Medis, dan Sistem Informasi Rumah Sakit (SIMRS). Dengan tim ahli yang berpengalaman dan berpengetahuan luas, kami memastikan setiap proyek dikerjakan dengan standar tertinggi, mulai dari perencanaan, instalasi, hingga pemeliharaan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="vision-mission-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="vision-mission-box">
                        <h3>Visi</h3>
                        <p>Menjadi perusahaan terkemuka dan terpercaya dalam penyediaan solusi teknologi medis yang inovatif dan andal, serta berkontribusi secara signifikan terhadap kemajuan industri kesehatan di Indonesia.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="vision-mission-box">
                        <h3>Misi</h3>
                        <ul>
                            <li>Menyediakan produk dan layanan berkualitas tinggi yang memenuhi standar internasional dan kebutuhan spesifik klien.</li>
                            <li>Membangun kemitraan jangka panjang dengan klien berdasarkan kepercayaan, integritas, dan kepuasan pelanggan.</li>
                            <li>Berinovasi secara berkelanjutan untuk menghadirkan teknologi medis terkini yang efisien dan efektif.</li>
                            <li>Mengembangkan sumber daya manusia yang kompeten dan profesional untuk memberikan layanan terbaik.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <h5 class="mb-4 text-center section-subtitle" style="color: #3e71a8;">Rumah Sakit Klien Kami</h5>
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-4 text-center">
                        <img src="{{ asset('img/RSUDsidoarjo.jpg') }}" alt="RSUD R.T. Notopuro Sidoarjo" class="img-fluid rounded" style="max-width: 150px; height: 100px; object-fit: contain;">
                        <div class="fw-bold mt-2" style="color: #3e71a8;">RSUD R.T. Notopuro Sidoarjo</div>
                        <small class="text-muted">Sidoarjo</small>
                    </div>
                    <div class="col-md-4 mb-4 text-center">
                        <img src="{{ asset('img/RSpusatpertamina.jpg') }}" alt="RS Pusat Pertamina Jakarta" class="img-fluid rounded" style="max-width: 150px; height: 100px; object-fit: contain;">
                        <div class="fw-bold mt-2" style="color: #3e71a8;">RS Pusat Pertamina Jakarta</div>
                        <small class="text-muted">Jakarta</small>
                    </div>
                    <div class="col-md-4 mb-4 text-center">
                        <img src="{{ asset('img/Rshasansadikin.png') }}" alt="RS Hasan Sadikin Bandung" class="img-fluid rounded" style="max-width: 150px; height: 100px; object-fit: contain;">
                        <div class="fw-bold mt-2" style="color: #3e71a8;">RS Hasan Sadikin Bandung</div>
                        <small class="text-muted">Bandung</small>
                    </div>
                    <div class="col-md-4 mb-4 text-center">
                        <img src="{{ asset('img/pelni.jpg') }}" alt="RS Pelni Petamburan Jakarta" class="img-fluid rounded" style="max-width: 150px; height: 100px; object-fit: contain;">
                        <div class="fw-bold mt-2" style="color: #3e71a8;">RS Pelni Petamburan Jakarta</div>
                        <small class="text-muted">Jakarta</small>
                    </div>
                    <div class="col-md-4 mb-4 text-center">
                        <img src="{{ asset('img/rscm.jpg') }}" alt="RS Cipto Mangunkusumo" class="img-fluid rounded" style="max-width: 150px; height: 100px; object-fit: contain;">
                        <div class="fw-bold mt-2" style="color: #3e71a8;">RS Cipto Mangunkusumo</div>
                        <small class="text-muted">Jakarta</small>
                    </div>
                    <div class="col-md-4 mb-4 text-center">
                        <img src="{{ asset('img/rsau.jpg') }}" alt="RSAU Antariksa Halim Perdanakusuma" class="img-fluid rounded" style="max-width: 150px; height: 100px; object-fit: contain;">
                        <div class="fw-bold mt-2" style="color: #3e71a8;">RSAU Antariksa Halim Perdanakusuma</div>
                        <small class="text-muted">Jakarta</small>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="{{ asset('img/company-profile.pdf') }}" class="btn btn-primary rounded-pill px-4 py-2" target="_blank" style="background-color: #3e71a8; border-color: #3e71a8;">
                    Unduh Profil Perusahaan
                </a>
            </div>
        </div>
    </section>
@endsection
