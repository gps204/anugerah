@forelse($products as $product)
<div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100 product-card shadow-sm">
        <a href="{{ route('product.show', $product->slug) }}">
            @if($product->images->isNotEmpty() && Storage::disk('public')->exists($product->images->first()->image_url))
                <img class="card-img-top" src="{{ Storage::url($product->images->first()->image_url) }}" alt="{{ $product->translation->name ?? '' }}" style="height: 200px; object-fit: cover;">
            @else
                {{-- Placeholder image jika tidak ada gambar --}}
                <img class="card-img-top" src="https://via.placeholder.com/300x200.png?text=No+Image" alt="No Image Available" style="height: 200px; object-fit: cover;">
            @endif
        </a>
        <div class="card-body d-flex flex-column">
            <h5 class="card-title">
                <a href="{{ route('product.show', $product->slug) }}">{{ $product->translation->name ?? 'Nama Produk Tidak Tersedia' }}</a>
            </h5>
            <div class="mt-auto">
                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary w-100">Lihat Detail & Minta Penawaran</a>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12"><p class="text-center">Tidak ada produk yang ditemukan.</p></div>
@endforelse