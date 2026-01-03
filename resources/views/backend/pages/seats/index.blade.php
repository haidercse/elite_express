@extends('backend.layouts.master')

@section('title', 'Seats')

@section('admin-content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between mb-3">
            <h4>Seats</h4>

            @can('seat.create')
                <button class="btn btn-primary" id="addBtn">
                    <i class="fa fa-plus"></i> Add Seat
                </button>
            @endcan
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>Seat No</th>
                            <th>Label</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Multiplier</th>
                            <th>Row</th>
                            <th>Col</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody id="seatTableBody">
                        @include('backend.pages.seats.partials.table', ['seats' => $seats])
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modal --}}
    <div class="modal fade" id="seatModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="seatForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Seat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="id">

                        <div class="mb-3">
                            <label>Vehicle</label>
                            <select id="vehicle_id" class="form-control">
                                <option value="">Select Vehicle</option>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">
                                        {{ $vehicle->name }} ({{ $vehicle->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Seat Number</label>
                            <input type="text" id="seat_number" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Seat Label</label>
                            <input type="text" id="seat_label" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Seat Type</label>
                            <select id="seat_type" class="form-control">
                                <option value="front">Front</option>
                                <option value="middle">Middle</option>
                                <option value="back">Back</option>
                                <option value="window">Window</option>
                                <option value="aisle">Aisle</option>
                                <option value="driver">Driver</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Category</label>
                            <select id="seat_category" class="form-control">
                                <option value="vip">VIP</option>
                                <option value="regular">Regular</option>
                                <option value="economy">Economy</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Fare Multiplier</label>
                            <input type="number" step="0.01" id="base_fare_multiplier" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Row</label>
                            <input type="number" id="position_row" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Column</label>
                            <input type="number" id="position_column" class="form-control">
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
            $('#seatForm')[0].reset();
            $('#id').val('');
            $('#seatModal').modal('show');
        });

        // Save
        $('#seatForm').submit(function(e) {
            e.preventDefault();

            let id = $('#id').val();
            let url = id ?
                `/admin/seats/update/${id}` :
                `/admin/seats/store`;

            $.ajax({
                url: url,
                method: "POST",
                data: {
                    vehicle_id: $('#vehicle_id').val(),
                    seat_number: $('#seat_number').val(),
                    seat_label: $('#seat_label').val(),
                    seat_type: $('#seat_type').val(),
                    seat_category: $('#seat_category').val(),
                    base_fare_multiplier: $('#base_fare_multiplier').val(),
                    position_row: $('#position_row').val(),
                    position_column: $('#position_column').val(),
                },
                success: function() {
                    $('#seatModal').modal('hide');
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

            $.get(`/admin/seats/edit/${id}`, function(data) {
                $('#id').val(data.id);
                $('#vehicle_id').val(data.vehicle_id);
                $('#seat_number').val(data.seat_number);
                $('#seat_label').val(data.seat_label);
                $('#seat_type').val(data.seat_type);
                $('#seat_category').val(data.seat_category);
                $('#base_fare_multiplier').val(data.base_fare_multiplier);
                $('#position_row').val(data.position_row);
                $('#position_column').val(data.position_column);

                $('#seatModal').modal('show');
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
                        url: `/admin/seats/delete/${id}`,
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
            $.get(`/admin/seats/list`, function(data) {
                $('#seatTableBody').html(data);
            });
        }
    </script>
@endpush
