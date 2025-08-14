@extends('admin.layouts.admin')

@section('title', __('cms.products.title_manage'))

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('cms.products.title_manage')</h3>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-sm float-end">@lang('cms.sidebar.products.add_new')</a>
                </div>
                <div class="card-body">
                    <table id="products-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>@lang('cms.products.name')</th>
                                <th>@lang('cms.products.category')</th>
                                <th>@lang('cms.products.brand')</th>
                                <th>@lang('cms.products.status')</th>
                                <th>@lang('cms.products.action')</th>
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
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(function () {
    var table = $('#products-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.products.data') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'category', name: 'category', orderable: false, searchable: false },
            { data: 'brand', name: 'brand', orderable: false, searchable: false },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
        }
    });

    // Handle status toggle
    $('#products-table').on('change', '.status-toggle', function() {
        var id = $(this).data('id');
        var status = $(this).is(':checked');

        $.ajax({
            url: "{{ route('admin.products.updateStatus') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                status: status
            },
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error('Gagal memperbarui status.');
                }
            }
        });
    });

    // Handle delete button
    $('#products-table').on('click', '.delete-btn', function() {
        var url = $(this).data('url');
        if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        table.ajax.reload();
                    } else {
                        toastr.error('Gagal menghapus produk.');
                    }
                }
            });
        }
    });

});
</script>
@endpush