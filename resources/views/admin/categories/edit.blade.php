@extends('admin.layouts.admin')

@section('title', __('cms.categories.edit'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('cms.categories.edit')</h3>
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

                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Kolom Kiri: Isian Terjemahan --}}
                            <div class="col-md-8">
                                <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                                    @foreach($activeLanguages as $language)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $language->name }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $language->name }}" type="button" role="tab">
                                                {{ ucwords($language->name) }}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content mt-3" id="languageTabContent">
                                    @foreach($activeLanguages as $language)
                                        @php
                                            $translation = $category->translations->where('language_code', $language->code)->first();
                                        @endphp
                                        <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $language->name }}" role="tabpanel">
                                            <div class="mb-3">
                                                <label class="form-label">@lang('cms.categories.name') ({{ $language->code }}) @if($language->code == config('app.locale')) <span class="text-danger">*</span> @endif</label>
                                                <input type="text" name="translations[{{ $language->code }}][name]" class="form-control" value="{{ old('translations.'.$language->code.'.name', $translation->name ?? '') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">@lang('cms.categories.description') ({{ $language->code }})</label>
                                                <textarea name="translations[{{ $language->code }}][description]" class="form-control ck-editor-multi-languages">{{ old('translations.'.$language->code.'.description', $translation->description ?? '') }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">@lang('cms.categories.image') ({{ $language->code }})</label>
                                                <input class="form-control" type="file" name="translations[{{ $language->code }}][image_url]">
                                                @if(isset($translation->image_url) && Storage::disk('public')->exists($translation->image_url))
                                                    <div class="mt-2">
                                                        <img src="{{ Storage::url($translation->image_url) }}" alt="Image" class="img-thumbnail" width="150">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Kolom Kanan: Isian Umum --}}
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="parent_category_id" class="form-label">Kategori Induk</label>
                                            <select class="form-select" id="parent_category_id" name="parent_category_id">
                                                <option value="">-- Tidak Ada --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ old('parent_category_id', $category->parent_category_id) == $cat->id ? 'selected' : '' }}>
                                                        {{ optional($cat->translations->first())->name ?? 'N/A' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1" {{ old('status', $category->status) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status">@lang('cms.categories.status') (Aktif)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">@lang('cms.categories.button')</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mt-3">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    document.querySelectorAll('.ck-editor-multi-languages').forEach((element) => {
        ClassicEditor
            .create(element)
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endpush