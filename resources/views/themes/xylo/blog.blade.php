@extends('themes.xylo.layouts.master')

@section('css')
<style>
    .blog-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    .blog-card .card-img-top {
        height: 250px;
        object-fit: cover;
    }
    .blog-card .card-title a {
        transition: color 0.3s ease;
        text-decoration: none;
    }
    .blog-card .card-title a:hover {
        color: #3e71a8 !important;
    }
    .pagination .page-link {
        color: #3e71a8;
    }
    .pagination .page-item.active .page-link {
        background-color: #3e71a8;
        border-color: #3e71a8;
    }
</style>
@endsection

@section('content')
<section class="blog-list-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h1 class="display-4 fw-bold" style="color: #3e71a8;">Blog Kami</h1>
                <p class="lead text-muted">Wawasan terbaru, berita, dan artikel dari tim kami.</p>
            </div>
        </div>

        <div class="row">
            @forelse($blogs as $blog)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm blog-card">
                        <a href="{{ route('blog.show', $blog->slug) }}">
                            <img src="{{ $blog->image ? Storage::url($blog->image) : 'https://via.placeholder.com/400x250.png?text=No+Image' }}" class="card-img-top" alt="{{ $blog->title }}">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><a href="{{ route('blog.show', $blog->slug) }}" class="text-dark">{{ $blog->title }}</a></h5>
                            <p class="card-text text-muted small mb-3">Oleh {{ optional($blog->user)->name ?? 'Admin' }} | {{ $blog->created_at->format('d M Y') }}</p>
                            <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($blog->content), 120) }}</p>
                            <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-outline-primary btn-sm align-self-start mt-auto">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center"><p class="lead">Belum ada postingan blog yang tersedia.</p></div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">{{ $blogs->links() }}</div>
    </div>
</section>
@endsection