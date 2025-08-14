
@extends('admin.layouts.admin')
@section('content')

<div class="card mt-4">
    <div class="card-header card-header-bg text-white">
        <h6 class="d-flex align-items-center mb-0 dt-heading">{{ __('cms.products.title_create') }}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                @foreach($activeLanguages as $language)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $language->name }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $language->name }}" type="button" role="tab">{{ ucwords($language->name) }}</button>
                    </li>
                @endforeach
            </ul>
     
            <div class="tab-content mt-3" id="languageTabContent">
                @foreach($activeLanguages as $language)
                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="{{ $language->name }}" role="tabpanel">
                        <label class="form-label">{{ __('cms.products.product_name') }} ({{ $language->code }})</label>
                        <input type="text"
                               name="translations[{{ $language->code }}][name]"
                               class="form-control @error("translations.{$language->code}.name") is-invalid @enderror"
                               value="{{ old("translations.{$language->code}.name") }}">
                        @error("translations.{$language->code}.name")
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
            
                        <label class="form-label mt-3">{{ __('cms.products.description') }} ({{ $language->code }})</label>
                        <textarea name="translations[{{ $language->code }}][description]"
                                  class="form-control ck-editor-multi-languages @error("translations.{$language->code}.description") is-invalid @enderror">{{ old("translations.{$language->code}.description") }}</textarea>
                        @error("translations.{$language->code}.description")
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach
            </div>
                       
            <div class="row mt-4">
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.products.category') }}</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->translation->name ?? '—' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('cms.products.brand') }}</label>
                    <select name="brand_id" class="form-control">
                        <option value="">{{ __('cms.products.no_brand') }}</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->translation->name ?? '—' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <label class="form-label">{{ __('cms.products.images') }}</label>
                <div class="custom-file">
                    <label class="btn btn-primary" for="productImages">{{ __('cms.products.choose_file') }}</label>
                    <input type="file" name="images[]" class="form-control d-none" id="productImages" multiple onchange="previewMultipleImages(this)">
                </div>

                <div id="productImagesPreview" class="mt-2 d-flex flex-wrap"></div>
            </div>  
         
            <div class="mt-4 text-start">
                <button type="submit" class="btn btn-primary">{{ __('cms.products.save_product') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script>
    let selectedFiles = []; 

    function previewMultipleImages(input) {
        const files = Array.from(input.files); 

        files.forEach(file => {
            if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                selectedFiles.push(file); 
            }
        });

        const previewContainer = document.getElementById('productImagesPreview');
        previewContainer.innerHTML = ''; 

        selectedFiles.forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail m-1';
                img.style.maxWidth = '150px';
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file); 
        });

        const dataTransfer = new DataTransfer(); 
        selectedFiles.forEach(file => dataTransfer.items.add(file)); 
        input.files = dataTransfer.files; 
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
@endsection 
