@extends('admin.layouts.admin')

@section('title', __('cms.brands.add_new'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('cms.brands.add_new')</h3>
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

                    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Kolom Kiri: Isian Terjemahan --}}
                            <div class="col-md-8">
                                @if($activeLanguages->isNotEmpty())
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
                                            <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $language->name }}" role="tabpanel">
                                                {{-- Name Field --}}
                                                <div class="mb-3">
                                                    <label class="form-label">@lang('cms.brands.name') ({{ $language->code }}) @if($language->code == config('app.locale')) <span class="text-danger">*</span> @endif</label>
                                                    <input type="text" name="translations[{{ $language->code }}][name]" class="form-control @error('translations.'.$language->code.'.name') is-invalid @enderror" value="{{ old('translations.'.$language->code.'.name') }}" {{ $language->code == config('app.locale') ? 'required' : '' }}>
                                                    @error('translations.'.$language->code.'.name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                {{-- Description Field --}}
                                                <div class="mb-3">
                                                    <label class="form-label">@lang('cms.brands.description') ({{ $language->code }})</label>
                                                    <textarea name="translations[{{ $language->code }}][description]" class="form-control ck-editor-multi-languages @error('translations.'.$language->code.'.description') is-invalid @enderror">{{ old('translations.'.$language->code.'.description') }}</textarea>
                                                    @error('translations.'.$language->code.'.description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="alert alert-warning" role="alert">
                                        <strong>Peringatan:</strong> Tidak ada bahasa yang aktif. Silakan aktifkan setidaknya satu bahasa di <a href="{{ route('admin.languages.index') }}" class="alert-link">pengaturan bahasa</a> sebelum dapat membuat merek baru.
                                    </div>
                                @endif
                            </div>

                            {{-- Kolom Kanan: Isian Umum --}}
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="logo" class="form-label">@lang('cms.brands.logo')</label>
                                            <input class="form-control @error('logo_url') is-invalid @enderror" type="file" id="logo_url" name="logo_url" onchange="previewLogo(this)">
                                            @error('logo_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div id="logo_preview" class="mt-2" style="display: none;">
                                                <img id="logo_preview_img" src="#" alt="@lang('cms.brands.image_preview')" class="img-thumbnail" style="max-width: 200px;">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">@lang('cms.brands.status')</label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>@lang('cms.vendors.active')</option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>@lang('cms.vendors.inactive')</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">@lang('cms.brands.button')</button>
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary mt-3">@lang('cms.brands.message_cancel')</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewLogo(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logo_preview_img').src = e.target.result;
                document.getElementById('logo_preview').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
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