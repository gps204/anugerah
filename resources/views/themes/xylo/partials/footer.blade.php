@php
    // Saran: Data ini idealnya disediakan melalui View Composer.
    // Lihat saran perbaikan di bawah untuk implementasi yang lebih baik.
    $settings = \Cache::remember('site_settings', 3600, fn() => \App\Models\SiteSetting::first());
    $privacyPage = \Cache::remember('privacy_page_url', 3600, fn() => \App\Models\Page::where('slug', 'privacy-policy')->value('slug'));
    $termsPage = \Cache::remember('terms_page_url', 3600, fn() => \App\Models\Page::where('slug', 'terms-of-service')->value('slug'));
@endphp

<footer class="footer-area">
    <div class="container">
        <div class="row">
            <!-- About Widget -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-widget">
                    <h5 class="widget-title">{{ __('store.footer.about_us') }}</h5>
                    <a href="{{ route('xylo.home') }}" class="d-block mb-3">
                        <img src="{{ asset('img/logoams.png') }}" alt="{{ __('store.footer.footer_logo_alt') }}" class="footer-logo" style="max-height: 45px; background-color: #fff; padding: 5px; border-radius: 5px;">
                    </a>
                    <p class="text-white fw-bold mb-1">PT. Anugerah Mitrautama Sejahtera</p>
                    <p class="text-muted">{{ $settings->tagline ?? 'Solusi lengkap untuk kebutuhan peralatan medis Anda.' }}</p>
                    <div class="contact-info mt-4">
                        <p class="text-muted d-flex"><i class="fa fa-map-marker-alt me-2 pt-1"></i> <span>{{ $settings->address ?? 'Jl. Kp. Parung Jambu No.7, Bogor' }}</span></p>
                        <p class="text-muted d-flex"><i class="fa fa-phone-alt me-2 pt-1"></i> <span>{{ $settings->contact_phone ?? '+62 816-717-942' }}</span></p>
                        <p class="text-muted d-flex"><i class="fa fa-envelope me-2 pt-1"></i> <span>{{ $settings->contact_email ?? 'info@ams-indo.com' }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Layanan Widget -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-widget">
                    <h5 class="widget-title">{{ __('store.footer.services') }}</h5>
                    <ul class="list-unstyled footer-links">
                        {{-- Arahkan ke halaman layanan atau bagian spesifik jika ada --}}
                        <li><a href="{{ route('services') }}#nursecall">Nursecall System</a></li>
                        <li><a href="{{ route('services') }}#gasmedis">Gas Medis</a></li>
                        <li><a href="{{ route('services') }}#simrs">SIM RS</a></li>
                        <li><a href="{{ route('contact') }}">Konsultasi</a></li>
                        <li><a href="{{ route('services') }}#maintenance">Maintenance</a></li>
                    </ul>
                </div>
            </div>

            <!-- Navigasi Widget -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-widget">
                    <h5 class="widget-title">Navigasi</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ route('xylo.home') }}">Beranda</a></li>
                        <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li><a href="{{ route('services') }}">Layanan</a></li>
                        <li><a href="{{ route('shop.index') }}">Produk</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a href="{{ route('contact') }}">Kontak</a></li>
                    </ul>
                </div>
            </div>

            <!-- Follow Us Widget -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-widget">
                    <h5 class="widget-title">{{ __('store.footer.follow_us') }}</h5>
                    <p class="text-muted mb-3">Terhubung dengan kami di media sosial.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/people/PT-ANUGERAH-MITRAUTAMA-SEJAHTERA/100064105890781/" target="_blank" class="social-icon" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.instagram.com/anugerahmitrautamasejahtera/" target="_blank" class="social-icon" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@anugerahmitra2012" target="_blank" class="social-icon" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <p class="copyright-text mb-0">{{ __('store.footer.copyright') }}</p>
            </div>
        </div>
    </div>
</footer>