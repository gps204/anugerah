@extends('themes.xylo.layouts.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"> 
@endsection
@section('content')
    @php $currency = activeCurrency(); @endphp
    <section class="products-home py-5 mb-5 main-shop">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold" style="color: #3e71a8;">Semua Produk</h1>
            <p class="lead text-muted">Temukan koleksi peralatan medis berkualitas tinggi untuk kebutuhan fasilitas kesehatan Anda.</p>
        </div>

        <div class="row">
            <aside class="col-md-3 d-none d-lg-inline">
                <div class="sidebar" id="filterSidebar">
                    <h5 class="mb-3">BRANDS</h5>
                    @foreach($brands as $brand)
                    <div class="form-check mb-3">
                        <input class="form-check-input filter-input" type="checkbox" name="brand[]" value="{{ $brand->id }}">
                        <label class="form-check-label">{{ mb_convert_case($brand->translation->name ?? $brand->slug, MB_CASE_TITLE, "UTF-8") }}</label>
                        <span class="text-muted">({{ $brand->products_count }})</span>
                    </div>
                    @endforeach

                    <h5 class="mb-3">CATEGORIES</h5>
                    @foreach($categories as $category)
                    <div class="form-check mb-3">
                        <input class="form-check-input filter-input" type="checkbox" name="category[]" value="{{ $category->id }}">
                        <label class="form-check-label">{{ mb_convert_case($category->translation->name ?? $category->slug, MB_CASE_TITLE, "UTF-8") }}</label>
                        <span class="text-muted">({{ $category->products_count }})</span>
                    </div>
                    @endforeach

                </div>
            </aside>
            <div class="col-md-9">
                <div class="row" id="productList">
                    @include('themes.xylo.partials.product-list')
                </div>
                <div id="paginationContainer" class="paginations d-flex justify-content-center align-items-center mt-5">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

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
        toastr.success(data.message, "{{ __('cms.products.success') }}", {
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

document.addEventListener('DOMContentLoaded', function () {
    function sendFilterRequest(url = null) {
        // Jika URL tidak disediakan (dari perubahan filter), buat URL baru.
        if (!url) {
            let baseUrl = "{{ route('shop.index') }}";
            let params = new URLSearchParams();

            document.querySelectorAll('.filter-input:checked').forEach(checked => {
                params.append(checked.name, checked.value);
            });

            // Reset ke halaman 1 saat filter diubah
            params.set('page', 1);
            url = `${baseUrl}?${params.toString()}`;
        }

        // Perbarui URL di browser tanpa memuat ulang halaman
        window.history.pushState({ path: url }, '', url);

        fetch(url, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json()) // Mengharapkan respons JSON
        .then(data => {
            // Perbarui daftar produk dan kontainer paginasi
            document.getElementById('productList').innerHTML = data.products_html;
            document.getElementById('paginationContainer').innerHTML = data.pagination_html;
        })
        .catch(error => console.error('Error during fetch:', error));
    }

    // Memicu filter saat input filter berubah
    document.querySelectorAll('.filter-input').forEach(input => {
        input.addEventListener('change', () => sendFilterRequest());
    });

    // Menangani klik pada link paginasi menggunakan event delegation
    document.getElementById('paginationContainer').addEventListener('click', function(event) {
        if (event.target.tagName === 'A' && event.target.closest('.pagination')) {
            event.preventDefault();
            sendFilterRequest(event.target.href);
        }
    });

    // Menggunakan event delegation untuk tombol wishlist karena produk dimuat melalui AJAX
    document.getElementById('productList').addEventListener('click', function(event) {
        const button = event.target.closest('.wishlist-btn');
        if (button) {
            const productId = button.getAttribute('data-product-id');

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
                    window.location.href = '/customer/login';
                } else if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Something went wrong');
                }
            })
            .then(data => {
                if (data?.message) {
                    toastr.success(data.message, "Wishlist", { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 3000 });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('Tidak dapat menambahkan ke wishlist.', "Error", { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 3000 });
            });
        }
    });
});
</script>
@endsection
