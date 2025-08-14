@extends('admin.layouts.admin')

@section('title', __('cms.social_media_links.edit'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('cms.social_media_links.edit') }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.social-media-links.update', $socialMediaLink->id) }}" method="POST">
               @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="type" class="form-label">{{ __('cms.social_media_links.type') }}</label>
                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                        <option value="" disabled>{{ __('cms.social_media_links.select_type') }}</option>
                        <option value="facebook" {{ old('type', $socialMediaLink->type) == 'facebook' ? 'selected' : '' }}>{{ __('cms.social_media_links.types.facebook') }}</option>
                        <option value="instagram" {{ old('type', $socialMediaLink->type) == 'instagram' ? 'selected' : '' }}>{{ __('cms.social_media_links.types.instagram') }}</option>
                        <option value="x" {{ old('type', $socialMediaLink->type) == 'x' ? 'selected' : '' }}>{{ __('cms.social_media_links.types.x') }}</option>
                        <option value="youtube" {{ old('type', $socialMediaLink->type) == 'youtube' ? 'selected' : '' }}>{{ __('cms.social_media_links.types.youtube') }}</option>
                        <option value="tiktok" {{ old('type', $socialMediaLink->type) == 'tiktok' ? 'selected' : '' }}>{{ __('cms.social_media_links.types.tiktok') }}</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @php $defaultLocale = config('app.locale', 'id'); @endphp
                <div class="mb-3">
                    <label for="platform_name" class="form-label">{{ __('cms.social_media_links.platform') }} ({{ strtoupper($defaultLocale) }})</label>
                    <input type="text" name="translations[{{ $defaultLocale }}][platform_name]" id="platform_name" class="form-control @error('translations.'.$defaultLocale.'.platform_name') is-invalid @enderror" value="{{ old('translations.'.$defaultLocale.'.platform_name', $translation->platform_name ?? '') }}" required>
                    @error('translations.'.$defaultLocale.'.platform_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="link" class="form-label">{{ __('cms.social_media_links.link') }}</label>
                    <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $socialMediaLink->link) }}" required placeholder="https://">
                    @error('link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', $socialMediaLink->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">{{ __('cms.social_media_links.status') }}</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.social-media-links.index') }}" class="btn btn-secondary me-2">{{ __('cms.brands.button_back') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('cms.social_media_links.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection