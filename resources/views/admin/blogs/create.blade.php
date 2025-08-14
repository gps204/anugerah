@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h6>{{ __('cms.blogs.title_create') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.blogs._form')
            </form>
        </div>
    </div>
</div>
@endsection