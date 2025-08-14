@extends('themes.xylo.layouts.master')

@section('css')
<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 2rem;
    }
    .product-card {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
        background: #fff;
    }
    .product-card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .product-img {
        position: relative;
        overflow: hidden;
    }
    .product-img img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .product-card:hover .product-img img {
        transform: scale(1.05);
    }
    .product-info {
        padding: 1rem;
    }
    .product-title {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 48px; /* 2 lines * 24px line-height */
    }
    .price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #3e71a8;
    }
    .has-discount {
        text-decoration: line-through;
        color: #999;
        font-weight: 400;
        margin-right: 0.5rem;
    }
    .discount {
        color: #d9534f;
    }
    .category-list .list-group-item.active {
        background-color: #3e71a8;
        border-color: #3e71a8;
    }
</style>
@endsection

@section('content')
    @php $currency = activeCurrency(); @endphp
    <!-- Banner Section -->
    <section class="banner-area inner-banner">
        <div class="container">
            <h1 class="text-center">Produk Kami</h1>
            <p class="text-center">Jelajahi berbagai produk teknologi medis berkualitas tinggi dari kami.</p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar for Filters -->
                <div class="col-lg-3">
                    @if(request()->has('category') || request()->has('brand'))
                        <div class="mb-4">
                             <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100">Hapus Semua Filter</a>
                        </div>
                    @endif

                    <h4 class="mb-4">Kategori</h4>
                    <div class="list-group category-list mb-4">
                        <a href="{{ route('products', request()->except('category')) }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                            Semua Kategori
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('products', array_merge(request()->query(), ['category' => $category->slug])) }}" class="list-group-item list-group-item-action {{ request('category') == $category->slug ? 'active' : '' }}">
                                {{ $category->translation->name ?? 'N/A' }}
                            </a>
                        @endforeach
                    </div>

                    <h4 class="mb-4">Merek</h4>
                    <div class="list-group brand-list">
                        <a href="{{ route('products', request()->except('brand')) }}" class="list-group-item list-group-item-action {{ !request('brand') ? 'active' : '' }}">
                            Semua Merek
                        </a>
                        @foreach($brands as $brand)
                            <a href="{{ route('products', array_merge(request()->query(), ['brand' => $brand->slug])) }}" class="list-group-item list-group-item-action {{ request('brand') == $brand->slug ? 'active' : '' }}">
                                {{ $brand->translation->name ?? 'N/A' }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    @if($products->count() > 0)
                        <div class="product-grid">
                            @foreach ($products as $product)
                                <div class="product-card">
                                    <div class="product-img">
                                        <a href="{{ route('product.show', $product->slug) }}">
                                            <img src="{{ Storage::url(optional($product->thumbnail)->image_url ?? 'default.jpg') }}"
                                                alt="{{ $product->translation->name ?? 'Product Name Not Available' }}">
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="h6">
                                            <a href="{{ route('product.show', $product->slug) }}" class="product-title">
                                                {{ $product->translation->name ?? 'Product Name Not Available' }}
                                            </a>
                                        </h3>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <p class="price mb-0">
                                                <span class="original {{ optional($product->primaryVariant)->converted_discount_price ? 'has-discount' : '' }}">
                                                    {{ $currency->symbol }}{{ optional($product->primaryVariant)->converted_price ?? 'N/A' }}
                                                </span>
                                                @if(optional($product->primaryVariant)->converted_discount_price)
                                                    <span class="discount">
                                                        {{ $currency->symbol }}{{ $product->primaryVariant->converted_discount_price }}
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-5 d-flex justify-content-center">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p>Tidak ada produk yang ditemukan untuk kategori ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection