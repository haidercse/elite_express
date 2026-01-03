@extends('backend.layouts.master')

@section('title', 'Trips')

@section('admin-content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between mb-3">
            <h4>Trips</h4>

            @can('trip.create')
                <button class="btn btn-primary" id="addBtn">
                    <i class="fa fa-plus"></i> Add Trip
                </button>
            @endcan
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Trip Code</th>
                            <th>Route</th>
                            <th>Vehicle</th>
                            <th>Date</th>
                            <th>Departure</th>
                            <th>Arrival</th>
                            <th>Fare</th>
                            <th>Status</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tripTableBody">
                        @include('backend.pages.trips.partials.table', ['trips' => $trips])
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modal --}}
    <div class="modal fade" id="tripModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="tripForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Trip</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="id">

                        <div class="mb-3">
                            <label>Route</label>
                            <select id="route_id" class="form-control">
                                <option value="">Select Route</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}">
                                        {{ $route->from_city }} → {{ $route->to_city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

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
                            <label>Date</label>
                            <input type="date" id="date" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Departure Time</label>
                            <input type="time" id="departure_time" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Arrival Time</label>
                            <input type="time" id="arrival_time" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Base Fare</label>
                            <input type="number" id="base_fare" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select id="status" class="form-control">
                                <option value="scheduled">Scheduled</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="completed">Completed</option>
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
            $('#tripForm')[0].reset();
            $('#id').val('');
            $('#tripModal').modal('show');
        });

        // Save
        $('#tripForm').submit(function(e) {
            e.preventDefault();

            let id = $('#id').val();
            let url = id ?
                `/admin/trips/update/${id}` :
                `/admin/trips/store`;

            $.ajax({
                url: url,
                method: "POST",
                data: {
                    route_id: $('#route_id').val(),
                    vehicle_id: $('#vehicle_id').val(),
                    date: $('#date').val(),
                    departure_time: $('#departure_time').val(),
                    arrival_time: $('#arrival_time').val(),
                    base_fare: $('#base_fare').val(),
                    status: $('#status').val(),
                },
                success: function() {
                    $('#tripModal').modal('hide');
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

            $.get(`/admin/trips/edit/${id}`, function(data) {
                $('#id').val(data.id);
                $('#route_id').val(data.route_id);
                $('#vehicle_id').val(data.vehicle_id);
                $('#date').val(data.date);
                $('#departure_time').val(data.departure_time);
                $('#arrival_time').val(data.arrival_time);
                $('#base_fare').val(data.base_fare);
                $('#status').val(data.status);

                $('#tripModal').modal('show');
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
                        url: `/admin/trips/delete/${id}`,
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
            $.get(`/admin/trips/list`, function(data) {
                $('#tripTableBody').html(data);
            });
        }
    </script>
@endpush
