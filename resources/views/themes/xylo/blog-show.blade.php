@extends('themes.xylo.layouts.master')

@section('css')
<style>
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
    .blog-header-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 2rem;
    }
</style>
@endsection

@section('content')
<section class="blog-post-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <article>
                    <header class="mb-4">
                        <h1 class="fw-bolder mb-1">{{ $blog->title }}</h1>
                        <div class="text-muted fst-italic mb-2">
                            Diposting pada {{ $blog->created_at->format('d F Y') }} oleh {{ optional($blog->user)->name ?? 'Admin' }}
                        </div>
                    </header>
                    
                    @if($blog->image)
                    <figure class="mb-4"><img class="blog-header-image" src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}"></figure>
                    @endif

                    <section class="mb-5 blog-content">{!! $blog->content !!}</section>
                </article>
                
                <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">&larr; Kembali ke Blog</a>
            </div>
        </div>
    </div>
</section>
@endsection