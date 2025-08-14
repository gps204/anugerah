@extends('themes.xylo.layouts.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection
@section('content')
@php $currency = activeCurrency(); @endphp
<section class="banner-area inner-banner pt-5 animate__animated animate__fadeIn productinnerbanner">
    <div class="container h-100">
        <div class="row">       
            <div class="col-md-4">
                <div class="breadcrumbs">
                    <a href="{{ route('xylo.home') }}">{{ __('cms.messages.home') }}</a>
                    @if(isset($product->category) && $product->category)
                        <i class="fa fa-angle-right"></i>
                        {{-- Tautan kategori sekarang mengarah ke halaman toko utama --}}
                        <a href="{{ route('shop.index') }}">{{ $product->category->translation->name }}</a>
                    @endif
                    <i class="fa fa-angle-right"></i> {{ $product->translation->name }}
                </div>
            </div>
        </div>
    </div>
</section>
<div class="main-detail pt-4 pb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 position-relative">
                <div class="product-slider">
                    @foreach ($product->images as $image)
                        <div>
                            <img src="{{ Storage::url($image['image_url']) }}" alt="{{ $image['name'] }}" style="width: 100%; height: auto;" />
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="col-md-6 pro-textarea">
                <h2 class="sec-heading">{{ $product->translation->name }}</h2>
                <div class="price-info-box my-3 p-3 border rounded bg-light">
                    <p class="mb-0 text-muted">Harga dapat bervariasi sesuai spesifikasi dan kebutuhan</p>
                </div>
                <p class="text-muted">{{ $product->translation->short_description }}</p>


                {{-- Bagian atribut dan varian produk tidak lagi diperlukan untuk model WhatsApp --}}

                @php
                    $productName = $product->translation->name;
                    $message = "Halo, saya tertarik untuk meminta penawaran untuk produk: " . $productName . ".";
                    // Nomor WhatsApp bisa diambil dari pengaturan situs jika ada
                    $whatsappNumber = '+628895530184';
                    $whatsappUrl = "https://api.whatsapp.com/send/?phone=" . preg_replace('/[^0-9]/', '', $whatsappNumber) . "&text=" . urlencode($message) . "&type=phone_number&app_absent=0";
                @endphp
                <div class="cart-actions mt-4">
                    <a href="{{ $whatsappUrl }}" class="read-more d-block text-center" target="_blank" rel="noopener noreferrer">Minta Penawaran</a>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="description-box py-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="mb-3">Deskripsi Produk</h3>
                <div class="description-content">
                    {!! $product->translation->description !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>  
    <script>
        $(document).ready(function() {
            $('.product-slider').slick({
                arrows: true,
                dots: false,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                prevArrow: '<button type="button" class="slick-prev">←</button>',
                nextArrow: '<button type="button" class="slick-next">→</button>',
            });
        });
    </script>

@endsection