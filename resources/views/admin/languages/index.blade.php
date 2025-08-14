@extends('admin.layouts.admin')

@section('title', __('cms.languages.title_list'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('cms.languages.title_list') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.languages.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> {{ __('cms.languages.add_new') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="languages-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('cms.languages.name') }}</th>
                                <th>{{ __('cms.languages.code') }}</th>
                                <th>{{ __('cms.languages.status') }}</th>
                                <th>{{ __('cms.languages.action') }}</th>
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

@push('scripts')
<script>
$(function () {
    var table = $('#languages-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.languages.data') }}",
            type: 'GET',
            data: function(d) {
                d._token = "{{ csrf_token() }}";
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        language: {
            url: '{{ asset('admin/plugins/datatables-i18n/'.app()->getLocale().'.json') }}'
        },
        responsive: true,
        autoWidth: false,
    });

    // Handle status toggle
    $('#languages-table').on('change', '.status-toggle', function() {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;
        var url = "{{ route('admin.languages.updateStatus') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                    table.ajax.reload(null, false); // Revert the switch
                }
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.message || 'An error occurred.');
                table.ajax.reload(null, false); // Revert the switch
            }
        });
    });

    // Handle delete button click
    $('#languages-table').on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var url = $(this).data('url');

        Swal.fire({
            title: '{{ __("cms.languages.confirm_delete") }}',
            text: '{{ __("cms.languages.confirm_delete_text") }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ __("cms.languages.delete") }}',
            cancelButtonText: '{{ __("cms.languages.cancel") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('{{ __("cms.success") }}', response.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON.message || 'An error occurred.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush