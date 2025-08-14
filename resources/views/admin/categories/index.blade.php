@extends('admin.layouts.admin')

@section('title', __('cms.categories.heading'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('cms.categories.heading') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> {{ __('cms.categories.add_new') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="categories-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('cms.categories.name') }}</th>
                                <th>{{ __('cms.categories.status') }}</th>
                                <th>{{ __('cms.categories.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
{{-- DataTables & Plugins --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    var table = $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.categories.data') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        responsive: true,
        autoWidth: false,
    });

    // Handle status toggle
    $('#categories-table').on('change', '.status-toggle', function() {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;
        var url = "{{ route('admin.categories.updateStatus') }}";

        $.post(url, { id: id, status: status, _token: '{{ csrf_token() }}' })
            .done(function(response) {
                if (window.toastr) {
                    if(response.success) {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message || 'An error occurred.');
                        table.ajax.reload(null, false);
                    }
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if (window.toastr) {
                    toastr.error('Could not update status. ' + (jqXHR.responseJSON.message || errorThrown));
                    table.ajax.reload(null, false);
                }
            });
    });

    // Handle delete button click
    $('#categories-table').on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var url = $(this).data('url');

        Swal.fire({
            title: '{{ __("cms.categories.message_confirm") }}',
            text: '{{ __("cms.categories.confirm_delete") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '{{ __("cms.categories.message_delete") }}',
            cancelButtonText: '{{ __("cms.categories.message_cancel") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: (response) => {
                        if (response.success) {
                            Swal.fire('{{ __("cms.success") }}', response.message, 'success');
                            table.ajax.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire('Error!', jqXHR.responseJSON.message || 'Could not delete the item.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush