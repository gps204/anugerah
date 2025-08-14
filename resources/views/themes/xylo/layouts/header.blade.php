<header class="sticky-top bg-white shadow-sm">
    <div class="container py-3">
        <div class="row align-items-center">
            <!-- Mobile Logo (Centered) -->
            <div class="col-12 d-md-none d-flex justify-content-center">
                <a href="{{ route('xylo.home') }}" class="navbar-brand d-flex align-items-center">
                    <img src="{{ asset('img/logoams.png') }}" width="50" alt="Logo" />
                </a>
            </div>

            <!-- Desktop Navbar (Logo, Menu, Button with balanced spacing) -->
            <div class="col-12 d-none d-md-flex justify-content-between align-items-center">
                <!-- Logo -->
                <a href="{{ route('xylo.home') }}" class="navbar-brand d-flex align-items-center">
                    <img src="{{ asset('img/logoams.png') }}" width="60" alt="Logo" />
                </a>

                <!-- Menu -->
                <nav>
                    <ul class="nav">
                        @php
                            // Define the static menu items and their routes/titles
                            $menuItems = [
                                'Beranda' => url('home'),
                                'Tentang Kami' => route('about'),
                                'Layanan' => route('services'),
                                'Produk' => url('/products'),
                                'Blog' => route('blog.index'),
                                'Kontak' => route('contact'),
                            ];
                        @endphp
                        @foreach ($menuItems as $title => $url)
                            <li class="nav-item">
                                <a class="nav-link menu-text-color" href="{{ $url }}">{{ $title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <!-- Tombol Tokopedia -->
                <a href="https://tokopedia.link/prtjHo63DVb" class="btn btn-success" target="_blank" rel="noopener noreferrer">
                    Tokopedia
                </a>
            </div>
        </div>
    </div>
</header>
