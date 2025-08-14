@extends('admin.layouts.admin')

@section('title', __('cms.social_media_links.list'))

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('cms.social_media_links.list') }}</h1>
        <a href="{{ route('admin.social-media-links.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> {{ __('cms.social_media_links.add_new') }}
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="social-links-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('cms.social_media_links.id') }}</th>
                            <th>{{ __('cms.social_media_links.platform') }}</th>
                            <th>{{ __('cms.social_media_links.link') }}</th>
                            <th>{{ __('cms.social_media_links.status') }}</th>
                            <th>{{ __('cms.social_media_links.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    var table = $('#social-links-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.social-media-links.data') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'platform_name', name: 'translation.platform_name'},
            {data: 'link', name: 'link'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        language: {
            url: '{{ asset('vendor/datatables/i18n/'.app()->getLocale().'.json') }}'
        }
    });

    // Handle status toggle
    $('#social-links-table').on('change', '.status-toggle', function() {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;
        var url = "{{ route('admin.social-media-links.updateStatus', ':id') }}".replace(':id', id);

        $.ajax({
            url: url,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                }
            },
            error: function() {
                toastr.error('Gagal memperbarui status.');
            }
        });
    });

    // Handle delete button
    $('#social-links-table').on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var url = $(this).data('url');

        Swal.fire({
            title: '{{ __("cms.social_media_links.massage_confirm") }}',
            text: '{{ __("cms.social_media_links.confirm_delete") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __("cms.social_media_links.massage_delete") }}',
            cancelButtonText: '{{ __("cms.social_media_links.massage_cancel") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if(response.success) {
                            Swal.fire(
                                '{{ __("cms.social_media_links.success") }}!',
                                response.message,
                                'success'
                            );
                            table.ajax.reload();
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Gagal menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
@endpush