@csrf
<div class="mb-3">
    <label for="title" class="form-label">{{ __('cms.blogs.title') }}</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $blog->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="content" class="form-label">{{ __('cms.blogs.content') }}</label>
    <textarea class="form-control @error('content') is-invalid @enderror" id="content-editor" name="content" rows="10">{{ old('content', $blog->content ?? '') }}</textarea>
    @error('content')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="image" class="form-label">{{ __('cms.blogs.image') }}</label>
    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" onchange="previewImage()">
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">{{ __('cms.blogs.image_preview') }}</label>
    @if(isset($blog) && $blog->image)
        <img id="image-preview" src="{{ Storage::url($blog->image) }}" alt="Image Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
    @else
        <img id="image-preview" src="#" alt="Image Preview" class="img-thumbnail" style="display:none; max-width: 200px; max-height: 200px;">
    @endif
</div>

<div class="mb-3">
    <label for="status" class="form-label">{{ __('cms.blogs.status') }}</label>
    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
        <option value="published" {{ old('status', $blog->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
        <option value="draft" {{ old('status', $blog->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">{{ __('cms.blogs.back_to_list') }}</a>
<button type="submit" class="btn btn-primary">{{ isset($blog) ? __('cms.blogs.update') : __('cms.blogs.save') }}</button>

@push('scripts')
<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('#image-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

</script>

@endpush

@push('scripts')
{{-- CKEditor 5 --}}
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
    // Inisialisasi CKEditor pada textarea dengan id 'content-editor'
    ClassicEditor
        .create(document.querySelector('#content-editor'), {
            // Konfigurasi tambahan bisa diletakkan di sini jika perlu
        })
        .catch(error => {
            console.error('There was a problem initializing the editor.', error);
        });
</script>
@endpush