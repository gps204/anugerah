@extends('themes.xylo.layouts.master')
@section('content')
    @php
        // Sebaiknya data ini disediakan dari View Composer atau AppServiceProvider
        $settings = \Cache::remember('site_settings', 3600, fn() => \App\Models\SiteSetting::first());
    @endphp
    @php $currency = activeCurrency(); @endphp
    {{-- Banner Section Start --}}
    <section class="banner-area">
        <div class="container">
            <div class="row align-items-center">
                <!-- Kolom Teks -->
                <div class="col-md-7">
                    <h3 class="display-4 fw-bold">Solusi Teknologi <span style="color: #3e71a8;">Medis</span> Terdepan</h3>
                    <p class="lead my-8 fw-light">
                        PT. Anugerah Mitrautama Sejahtera adalah perusahaan terpercaya dalam pemasangan dan instalasi Nursecall System, Gas Medis, dan Sistem Informasi Rumah Sakit (SIM RS).
                    </p>
                    <a href="{{ route('services') }}" class="btn btn-primary btn-lg rounded-pill px-4" style="background-color: #3e71a8; border-color: #3e71a8;">
                        Lihat Selengkapnya
                    </a>
                </div>
                <!-- Kolom Video -->
                <div class="col-md-5 text-center d-none d-md-block">
                    <video class="img-fluid" style="width: 50%; border-radius: 10px;" autoplay loop muted playsinline>
                        <source src="{{ asset('img/amsvideo.mp4') }}" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>
            </div>
        </div>
    </section>
    {{-- Banner Section End --}}

    <!-- About Us Section Start -->
    <section class="about-us-home py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h2 class="display-5 fw-bold mb-3" style="color: #3e71a8;">Tentang Kami</h2>
                    <p class="lead text-muted mb-4 mx-auto" style="max-width: 800px;">
                        PT. Anugerah Mitrautama Sejahtera (AMS) adalah partner terpercaya Anda dalam penyediaan dan instalasi sistem teknologi medis canggih. Kami berkomitmen untuk meningkatkan kualitas layanan kesehatan di Indonesia melalui produk inovatif dan layanan profesional.
                    </p>
                    <div class="row mb-4 text-start">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="fa fa-check-circle fa-2x me-3" style="color: #3e71a8;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1" style="color: #3e71a8;">Produk Berkualitas</h5>
                                    <p class="mb-0 text-muted small">Menyediakan peralatan medis dengan standar internasional.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="fa fa-cogs fa-2x me-3" style="color: #3e71a8;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1" style="color: #3e71a8;">Instalasi Profesional</h5>
                                    <p class="mb-0 text-muted small">Tim ahli memastikan instalasi berjalan lancar dan aman.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="fa fa-headset fa-2x me-3" style="color: #3e71a8;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1" style="color: #3e71a8;">Dukungan Purna Jual</h5>
                                    <p class="mb-0 text-muted small">Layanan pelanggan dan teknis yang responsif.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0">
                                    <i class="fa fa-lightbulb fa-2x me-3" style="color: #3e71a8;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1" style="color: #3e71a8;">Solusi Inovatif</h5>
                                    <p class="mb-0 text-muted small">Selalu mengikuti perkembangan teknologi terkini.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h5 class="mb-2" style="color: #3e71a8;">Rumah Sakit Klien Kami</h5>
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
                    </div>


                    <a href="{{ route('about') }}" class="btn btn-primary rounded-pill px-4 mt-3" style="background-color: #3e71a8; border-color: #3e71a8;">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End -->

    <!-- Services Section Start -->
    <section class="service-section py-5">
        <div class="container">
            <h2 class="sec-heading mb-5" style="color: #3e71a8;">Layanan Kami</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="service-card">
                        <i class="fa fa-medkit"></i>
                        <h3>Nursecall System</h3>
                        <p>Pemasangan dan pemeliharaan sistem panggilan perawat yang handal.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card">
                        <i class="fa fa-fire"></i>
                        <h3>Gas Medis</h3>
                        <p>Instalasi dan perawatan sistem gas medis yang aman dan efisien.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card">
                        <i class="fa fa-hospital"></i>
                        <h3>SIM RS</h3>
                        <p>Pengembangan dan implementasi Sistem Informasi Rumah Sakit yang terintegrasi.</p>
                    </div>
                </div>
            </div>
            <div class="view-button text-center mt-4" >
                <a href="{{ route('services') }}" class="btn btn-primary rounded-pill px-4 mt-3" style="background-color: #3e71a8; border-color: #3e71a8;">Lihat Semua Layanan</a>
            </div>
        </div>
    </section>

    <section class="trending-products animate-on-scroll">
        <div class="container position-relative">
            <h2 class="sec-heading mb-5" style="color: #3e71a8;">Produk</h2>

            <div class="product-slider">
                @foreach ($products as $product)
                    <div class="product-card h-100 d-flex flex-column border rounded p-3 shadow-sm m-2">
                        <div class="product-img">
                            <img src="{{ Storage::url(optional($product->thumbnail)->image_url ?? 'default.jpg') }}" 
                                alt="{{ $product->translation->name ?? 'Product Name Not Available' }}">
                                <button class="wishlist-btn" data-product-id="{{ $product->id }}">
                                    <i class="fa-solid fa-heart"></i>
                                </button>
                        </div>
                        <div class="product-info mt-3 d-flex flex-column flex-grow-1">
                            <div class="top-info">
                            </div>
                            <div class="bottom-info mt-auto">
                                <div class="left">
                                    <h3>
                                        <a href="{{ route('product.show', $product->slug) }}" class="product-title">
                                            {{ $product->translation->name ?? 'Product Name Not Available' }}
                                        </a>
                                    </h3>
                                    <p class="price-info text-muted" style="font-size: 0.85rem;">
                                        Harga dapat bervariasi sesuai spesifikasi dan kebutuhan
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Custom Arrows -->
            <div class="custom-arrows">
                <button class="prev"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="next"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <div class="view-button text-center my-5">
        <a href="{{ route('shop.index') }}" class="btn btn-primary rounded-pill px-4" style="background-color: #3e71a8; border-color: #3e71a8;">Lihat Semua Produk</a>
    </div>

    {{-- Latest Blog Section Start --}}
    @php
        // Mengambil 3 postingan blog terbaru yang statusnya 'published'
        $latest_blogs = \App\Models\Blog::with('user')
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();
    @endphp

    @if($latest_blogs->isNotEmpty())
    <section class="latest-blog-section py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <h2 class="sec-heading mb-5" style="color: #3e71a8;">Dari Blog Kami</h2>
            <div class="row">
                @foreach($latest_blogs as $blog)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm blog-card">
                            <a href="{{ route('blog.show', $blog->slug) }}">
                                <img src="{{ $blog->image ? Storage::url($blog->image) : 'https://via.placeholder.com/400x250.png?text=No+Image' }}" class="card-img-top" alt="{{ $blog->title }}" style="height: 250px; object-fit: cover;">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><a href="{{ route('blog.show', $blog->slug) }}" class="text-dark" style="text-decoration: none;">{{ $blog->title }}</a></h5>
                                <p class="card-text text-muted small mb-3">Oleh {{ optional($blog->user)->name ?? 'Admin' }} | {{ $blog->created_at->format('d M Y') }}</p>
                                <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($blog->content), 100) }}</p>
                                <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-outline-primary btn-sm align-self-start mt-auto">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="view-button text-center mt-4">
                <a href="{{ route('blog.index') }}" class="btn btn-primary rounded-pill px-4" style="background-color: #3e71a8; border-color: #3e71a8;">Lihat Semua Postingan</a>
            </div>
        </div>
    </section>
    <style>
        .blog-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }
        .blog-card .card-title a:hover {
            color: #3e71a8 !important;
        }
    </style>
    @endif
    {{-- Latest Blog Section End --}}

    <!-- Home Contact & Map Section Start -->
    <style>
        .contact-form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            height: 100%;
        }
        .contact-info-container {
            background-color: #3e71a8;
            color: #fff;
            padding: 40px;
            border-radius: 8px;
            height: 100%;
        }
        .contact-info-container h3 {
            color: #fff;
            margin-bottom: 20px;
        }
        .contact-info-container p {
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .contact-info-container i {
            margin-right: 15px;
            width: 20px;
        }
    </style>
    <section class="home-contact-map-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="contact-info-container">
                        <h3>Informasi Kontak</h3>
                        <div class="d-flex" style="margin-bottom: 15px; font-size: 1.1rem;">
                            <i class="fa fa-map-marker-alt pt-1"></i>
                            <div>
                                <span>Jl.Nusantara IX, Blok HK Perum.BDB 2 No.03 Sukahati, Kec. Cibinong, Kabupaten Bogor Jawa Barat 16913, Indonesia</span>
                            </div>
                        </div>
                        <div class="d-flex" style="margin-bottom: 15px; font-size: 1.1rem;">
                            <i class="fa fa-phone-alt pt-1"></i>
                            <div>
                                <span>+62816717942</span><br>
                                <span>+628895530184</span>
                            </div>
                        </div>
                        <div class="d-flex" style="margin-bottom: 15px; font-size: 1.1rem;">
                            <i class="fa fa-envelope pt-1"></i>
                            <div>
                                <span>info@ams-indo.com</span><br>
                                <span>amsindo.pwt@gmail.com</span>
                            </div>
                        </div>
                        <hr class="border-light my-4">
                        <h4 class="h5">Jam Kerja</h4>
                        <p class="mb-1">Senin - Jumat: 09:00 - 17:00</p>
                        <p>Sabtu - Minggu: Tutup</p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact-form-container p-4">
                        <h3 class="d-flex align-items-center mb-4" style="color: #3e71a8; font-weight: 600;">
                            <i class="fa fa-map-marked-alt me-3"></i> Lokasi Kami di Peta
                        </h3>
                        <div class="map-wrapper" style="border-radius: 8px; overflow: hidden; height: 400px;">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.582811915951!2d106.7987981749921!3d-6.500698893501198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c30b547f0a33%3A0xc21e8e25e072d5f3!2sPT.Anugerah%20Mitrautama%20Sejahtera!5e0!3m2!1sen!2sid!4v1717051515881!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home Contact & Map Section End -->

    <!-- Emergency Contact Section -->
    <section class="emergency-contact-section py-5">
        <div class="container">
            <div class="text-center p-4" style="background-color: #eaf2f8; border-radius: 8px;">
                <h3 class="mb-3" style="color: #3e71a8; font-weight: 600;">Butuh Bantuan Segera?</h3>
                <p class="mb-4 text-muted">Tim emergency support kami siap membantu Anda 24/7 untuk kebutuhan mendesak peralatan medis.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('contact') }}" class="btn btn-primary px-5 py-2">
                        <i class="fa fa-envelope me-2"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

<!--
[PROMPT_SUGGESTION]Berikan saran untuk meningkatkan tampilan bagian layanan di beranda.[/PROMPT_SUGGESTION]
[PROMPT_SUGGESTION]Bagaimana cara menambahkan animasi ke bagian layanan saat pengguna menggulir halaman?[/PROMPT_SUGGESTION]
-->
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
        function addToCart(productId) {

            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                toastr.success("{{ session('success') }}", data.message, {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-right",
                    timeOut: 5000
                });
                updateCartCount(data.cart);
            })
            .catch(error => console.error("Error:", error));
        }

        function updateCartCount(cart) {
            let totalCount = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById("cart-count").textContent = totalCount;
        }
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.wishlist-btn').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');

            fetch('/customer/wishlist', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => {
                if (response.status === 401) {
                    // Not logged in
                    window.location.href = '/customer/login';
                } else if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Something went wrong');
                }
            })
            .then(data => {
                if (data?.message) {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
@endsection

<!--
[PROMPT_SUGGESTION]Berikan saran untuk meningkatkan tampilan bagian "Rumah Sakit Klien Kami" di beranda.[/PROMPT_SUGGESTION]
[PROMPT_SUGGESTION]Bagaimana cara membuat carousel pada bagian "Rumah Sakit Klien Kami"?[/PROMPT_SUGGESTION]
-->
