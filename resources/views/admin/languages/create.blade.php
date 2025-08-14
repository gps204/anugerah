@extends('admin.layouts.admin')

@section('title', __('cms.languages.add_new'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('cms.languages.add_new')</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.languages.store') }}" method="POST">
                        @csrf

                        {{-- Name Field --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">@lang('cms.languages.name') <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Code Field --}}
                        <div class="mb-3">
                            <label for="code" class="form-label">@lang('cms.languages.code') <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="code"
                                   id="code"
                                   class="form-control @error('code') is-invalid @enderror"
                                   value="{{ old('code') }}"
                                   required
                                   maxlength="2"
                                   minlength="2">
                            <div class="form-text">Gunakan kode bahasa 2 huruf sesuai standar ISO 639-1. Contoh: 'en' untuk English, 'id' untuk Indonesia.</div>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Field --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">@lang('cms.languages.status')</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>@lang('cms.active')</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>@lang('cms.inactive')</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">@lang('cms.buttons.create')</button>
                        <a href="{{ route('admin.languages.index') }}" class="btn btn-secondary">@lang('cms.buttons.cancel')</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection