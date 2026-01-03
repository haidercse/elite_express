@extends('backend.layouts.master')

@section('title', 'Vehicle Types')

@section('admin-content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between mb-3">
            <h4>Vehicle Types</h4>

            @can('vehicle-type.create')
                <button class="btn btn-primary" id="addBtn">
                    <i class="fa fa-plus"></i> Add Vehicle Type
                </button>
            @endcan
        </div>

        <div class="card">
            <div class="card-body" id="vehicleTypeTable">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Seat Count</th>
                            <th>Status</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody id="vehicleTypeTableBody">
                        @include('backend.pages.vehicle_types.partials.table', ['types' => $types])
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modal --}}
    <div class="modal fade" id="vehicleTypeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="vehicleTypeForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Vehicle Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="id">

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" id="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Seat Count</label>
                            <input type="number" id="seat_count" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Add
        $(document).on('click', '#addBtn', function() {
            $('#vehicleTypeForm')[0].reset();
            $('#id').val('');
            $('#vehicleTypeModal').modal('show');
        });

        // Save
        $('#vehicleTypeForm').submit(function(e) {
            e.preventDefault();

            let id = $('#id').val();
            let url = id ?
                `/admin/vehicle-types/update/${id}` :
                `/admin/vehicle-types/store`;

            $.ajax({
                url: url,
                method: "POST",
                data: {
                    name: $('#name').val(),
                    seat_count: $('#seat_count').val(),
                    status: $('#status').val(),
                },
                success: function() {
                    $('#vehicleTypeModal').modal('hide');
                    toastSuccess("Saved successfully!");
                    reloadTable();
                },
                error: function(xhr) {
                    handleValidationErrors(xhr);
                }
            });
        });

        // Edit
        $(document).on('click', '.editBtn', function() {
            let id = $(this).data('id');

            $.get(`/admin/vehicle-types/edit/${id}`, function(data) {
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#seat_count').val(data.seat_count);
                $('#status').val(data.status);
                $('#vehicleTypeModal').modal('show');
            });
        });

        // Delete
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/vehicle-types/delete/${id}`,
                        method: "DELETE",
                        success: function() {
                            toastSuccess("Deleted!");
                            reloadTable();
                        }
                    });
                }
            });
        });

        // Reload Table
        function reloadTable() {
            $.get(`/admin/vehicle-types/list`, function(data) {
                $('#vehicleTypeTableBody').html(data);
            });
        }
    </script>
@endpush
