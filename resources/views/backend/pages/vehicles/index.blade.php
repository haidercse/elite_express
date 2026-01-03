@extends('backend.layouts.master')

@section('title', 'Vehicles')

@section('admin-content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between mb-3">
            <h4>Vehicles</h4>

            @can('vehicle.create')
                <button class="btn btn-primary" id="addBtn">
                    <i class="fa fa-plus"></i> Add Vehicle
                </button>
            @endcan
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Plate Number</th>
                            <th>Total Seats</th>
                            <th>Status</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody id="vehicleTableBody">
                        @include('backend.pages.vehicles.partials.table', ['vehicles' => $vehicles])
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modal --}}
    <div class="modal fade" id="vehicleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="vehicleForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Vehicle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="id">

                        <div class="mb-3">
                            <label>Vehicle Type</label>
                            <select id="vehicle_type_id" class="form-control">
                                <option value="">Select Type</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" id="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Plate Number</label>
                            <input type="text" id="plate_number" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Total Seats</label>
                            <input type="number" id="total_seats" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select id="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
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
            $('#vehicleForm')[0].reset();
            $('#id').val('');
            $('#vehicleModal').modal('show');
        });

        // Save
        $('#vehicleForm').submit(function(e) {
            e.preventDefault();

            let id = $('#id').val();
            let url = id ?
                `/admin/vehicles/update/${id}` :
                `/admin/vehicles/store`;

            $.ajax({
                url: url,
                method: "POST",
                data: {
                    vehicle_type_id: $('#vehicle_type_id').val(),
                    name: $('#name').val(),
                    plate_number: $('#plate_number').val(),
                    total_seats: $('#total_seats').val(),
                    status: $('#status').val(),
                },
                success: function() {
                    $('#vehicleModal').modal('hide');
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

            $.get(`/admin/vehicles/edit/${id}`, function(data) {
                $('#id').val(data.id);
                $('#vehicle_type_id').val(data.vehicle_type_id);
                $('#name').val(data.name);
                $('#plate_number').val(data.plate_number);
                $('#total_seats').val(data.total_seats);
                $('#status').val(data.status);

                $('#vehicleModal').modal('show');
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
                        url: `/admin/vehicles/delete/${id}`,
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
            $.get(`/admin/vehicles/list`, function(data) {
                $('#vehicleTableBody').html(data);
            });
        }
    </script>
@endpush
