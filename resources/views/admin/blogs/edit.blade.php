@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.blogs.title_edit') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.blogs._form', ['blog' => $blog])
            </form>
        </div>
    </div>
</div>
@endsection