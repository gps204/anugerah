@extends('admin.layouts.admin')

@section('css')
<style>
    body {
        background-color: #f4f6f9;
        color: #333333;
    }
    .dashboard-item {
        display: flex;
        align-items: center;
        padding: 20px;
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.07);
        transition: transform 0.2s;
    }
    .dashboard-item:hover {
        transform: translateY(-3px);
    }
    .icon-container {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    .icon-container i {
        font-size: 24px;
        color: #fff;
    }
    .text-container {
        flex-grow: 1;
    }
    .text-container h6 {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
    }
    .text-container p {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #343a40;
    }
    .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #f4f4f4;
    }
    .table a {
        text-decoration: none;
        font-weight: 500;
    }
    .table a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="row g-4">
            <!-- Total Produk -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-item">
                    <div class="icon-container" style="background-color: #17a2b8;">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="text-container">
                        <h6>Total Produk</h6>
                        <p>{{ $totalProducts }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Kategori -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-item">
                    <div class="icon-container" style="background-color: #28a745;">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <div class="text-container">
                        <h6>Total Kategori</h6>
                        <p>{{ $totalCategories }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Pelanggan -->
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-item">
                    <div class="icon-container" style="background-color: #ffc107;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="text-container">
                        <h6>Total Pelanggan</h6>
                        <p>{{ $totalCustomers }}</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-4 g-4">
            <!-- Produk Terbaru -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Produk Terbaru</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Tanggal Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentProducts as $product)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.products.edit', $product->id) }}">
                                                    {{ Str::limit($product->translation->name ?? 'N/A', 30) }}
                                                </a>
                                            </td>
                                            <td>{{ $product->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center py-4">Tidak ada produk.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pelanggan Terbaru -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pelanggan Terbaru</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentCustomers as $customer)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.customers.show', $customer->id) }}">
                                                    {{ $customer->name }}
                                                </a>
                                            </td>
                                            <td>{{ $customer->email }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center py-4">Tidak ada pelanggan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
