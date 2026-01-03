@extends('backend.layouts.master')

@section('title', 'Routes')

@section('admin-content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between mb-3">
            <h4>Routes</h4>

            @can('route.create')
                <button class="btn btn-primary" id="addBtn">
                    <i class="fa fa-plus"></i> Add Route
                </button>
            @endcan
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>To</th>
                            <th>Distance (KM)</th>
                            <th>Duration (Min)</th>
                            <th>Status</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody id="routeTableBody">
                        @include('backend.pages.routes.partials.table', ['routes' => $routes])
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modal --}}
    <div class="modal fade" id="routeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="routeForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Route</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="id">

                        <div class="mb-3">
                            <label>From City</label>
                            <input type="text" id="from_city" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>To City</label>
                            <input type="text" id="to_city" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Distance (KM)</label>
                            <input type="number" id="distance_km" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Approx Duration (Minutes)</label>
                            <input type="number" id="approx_duration_minutes" class="form-control">
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
            $('#routeForm')[0].reset();
            $('#id').val('');
            $('#routeModal').modal('show');
        });

        // Save
        $('#routeForm').submit(function(e) {
            e.preventDefault();

            let id = $('#id').val();
            let url = id ?
                `/admin/routes/update/${id}` :
                `/admin/routes/store`;

            $.ajax({
                url: url,
                method: "POST",
                data: {
                    from_city: $('#from_city').val(),
                    to_city: $('#to_city').val(),
                    distance_km: $('#distance_km').val(),
                    approx_duration_minutes: $('#approx_duration_minutes').val(),
                    status: $('#status').val(),
                },
                success: function() {
                    $('#routeModal').modal('hide');
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

            $.get(`/admin/routes/edit/${id}`, function(data) {
                $('#id').val(data.id);
                $('#from_city').val(data.from_city);
                $('#to_city').val(data.to_city);
                $('#distance_km').val(data.distance_km);
                $('#approx_duration_minutes').val(data.approx_duration_minutes);
                $('#status').val(data.status);

                $('#routeModal').modal('show');
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
                        url: `/admin/routes/delete/${id}`,
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
            $.get(`/admin/routes/list`, function(data) {
                $('#routeTableBody').html(data);
            });
        }
    </script>
@endpush
