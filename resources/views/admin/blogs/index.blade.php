@extends('admin.layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h6>{{ __('cms.blogs.title_list') }}</h6>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-light btn-sm">{{ __('cms.blogs.add_new') }}</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="blogs-table">
                    <thead>
                        <tr>
                            <th>{{ __('cms.blogs.id') }}</th>
                            <th>{{ __('cms.blogs.title') }}</th>
                            <th>{{ __('cms.blogs.author') }}</th>
                            <th>{{ __('cms.blogs.status') }}</th>
                            <th>{{ __('cms.blogs.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    {{-- CSS untuk DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
{{-- JavaScript untuk DataTables --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function() {
    var table = $('#blogs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.blogs.data') }}',
            type: 'GET',
            error: function (xhr, error, thrown) {
                // Handler ini sangat penting untuk debugging
                console.error('DataTables AJAX error:', xhr.responseText);
                alert('Terjadi error saat mengambil data. Silakan periksa browser console (F12) untuk detail lebih lanjut.');
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            { data: 'author', name: 'author' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Handle status switch change
    $('#blogs-table').on('change', '.status-switch', function() {
        var blogId = $(this).data('id');
        var status = $(this).is(':checked');

        $.ajax({
            url: '{{ route('admin.blogs.updateStatus') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: blogId,
                status: status
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message, '{{ __('cms.blogs.success') }}');
                    table.ajax.reload(null, false); // reload datatable
                } else {
                    toastr.error('{{ __('cms.blogs.error') }}', 'Error');
                }
            },
            error: function() {
                toastr.error('{{ __('cms.blogs.error') }}', 'Error');
            }
        });
    });

    // Handle delete button click
    $('#blogs-table').on('click', '.delete-btn', function() {
        var deleteUrl = $(this).data('url');
        
        Swal.fire({
            title: '{{ __('cms.blogs.confirm_delete_title') }}',
            text: '{{ __('cms.blogs.confirm_delete_body') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ __('cms.blogs.delete') }}',
            cancelButtonText: '{{ __('cms.blogs.cancel') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    method: 'POST', // Using POST with _method for DELETE
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if(response.success) {
                            toastr.success(response.message, '{{ __('cms.blogs.success') }}');
                            table.ajax.reload();
                        }
                    }
                });
            }
        });
    });
});
</script>
@endpush