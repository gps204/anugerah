@extends('themes.xylo.layouts.master')

@section('content')
<style>
    .contact-form-section {
        background-color: #f8f9fa;
    }
    .contact-form-container {
        background-color: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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
    }
    .contact-info-container i {
        margin-right: 15px;
    }
</style>

<section class="contact-form-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold" style="color: #3e71a8;">Hubungi Kami</h1>
            <p class="lead text-muted">Punya pertanyaan atau butuh informasi lebih lanjut? Jangan ragu untuk menghubungi kami.</p>
        </div>

        <div class="row">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="contact-form-container">
                    <h3 class="mb-4" style="color: #3e71a8;">Kirim Pesan</h3>

                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subjek</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan Anda</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4" style="background-color: #3e71a8; border-color: #3e71a8;">Kirim Pesan</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contact-info-container">
                    <h3 class="mb-4">Informasi Kontak</h3>
                    <p class="d-flex mb-3"><i class="fa fa-map-marker-alt fa-lg pt-1"></i> <span>Jl.Nusantara IX, Blok HK Perum.BDB 2 No.03 Sukahati, Kec. Cibinong, Kabupaten Bogor Jawa Barat 16913, Indonesia</span></p>
                    <p class="d-flex mb-3"><i class="fa fa-phone-alt fa-lg pt-1"></i> <span>+62816717942 / +628895530184</span></p>
                    <p class="d-flex mb-3"><i class="fa fa-envelope fa-lg pt-1"></i> <span>info@ams-indo.com / amsindo.pwt@gmail.com</span></p>
                    <hr class="border-light my-4">
                    <h4 class="h5">Jam Kerja</h4>
                    <p class="mb-1">Senin - Jumat: 09:00 - 17:00</p>
                    <p>Sabtu - Minggu: Tutup</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection