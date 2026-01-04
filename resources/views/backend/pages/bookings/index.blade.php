@extends('backend.layouts.master')

@section('title', 'Bookings')

@section('admin-content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between m-2">
            <h4>Bookings</h4>

            <button class="btn btn-primary addBookingBtn">
                <i class="fa fa-plus"></i> New Booking
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Passenger</th>
                            <th>Trip</th>
                            <th>Seat</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th width="140">Action</th>
                        </tr>
                    </thead>
                    <tbody id="bookingTable">
                        @include('backend.pages.bookings.partials.table', ['bookings' => $bookings])
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Modals --}}
    @include('backend.pages.bookings.partials.create-modal')
    @include('backend.pages.bookings.partials.show-modal')
    @include('backend.pages.bookings.partials.edit-modal')
@endsection

@push('scripts')
    <script>
        let bookingDataTable;

        // ============================
        // INIT DATATABLE (ONLY ONCE)
        // ============================
        $(document).ready(function() {
            initBookingTable();
        });

        function initBookingTable() {
            bookingDataTable = $('#dataTable').DataTable({
                pageLength: 10,
                ordering: true,
                order: [
                    [0, 'desc']
                ],
                destroy: true
            });
        }

        // ============================
        // GLOBAL HELPERS
        // ============================
        window.openBookingModal = function() {
            $('#bookingForm')[0].reset();
            $('#trip_id').val('');
            $('#seatArea').html('');
            $('#bookingModal').modal('show');
        }

        window.openBookingShowModal = function(id) {
            $('#bookingShowBody').load(`/admin/bookings/show/${id}`, function() {
                $('#bookingShowModal').modal('show');
            });
        }

        // ============================
        // EVENTS
        // ============================
        $(document).on('click', '.addBookingBtn', openBookingModal);

        $(document).on('change', '#trip_id', function() {
            let tripId = $(this).val();
            $('#seatArea').load(
                tripId ? `/admin/bookings/seat-list/${tripId}` : ''
            );
        });

        // CREATE
        $(document).on('submit', '#bookingForm', function(e) {
            e.preventDefault();

            $.post("{{ route('admin.bookings.store') }}", $(this).serialize())
                .done(res => {
                    if (res.success) {
                        toastSuccess(res.message);
                        $('#bookingModal').modal('hide');
                        reloadBookingTable();
                    } else toastError(res.message);
                })
                .fail(handleValidationErrors);
        });

        // DELETE
        $(document).on('click', '.deleteBookingBtn', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/bookings/delete/${id}`,
                        method: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: res => {
                            res.success ?
                                (toastSuccess(res.message), reloadBookingTable()) :
                                toastError(res.message);
                        }
                    });
                }
            });
        });

        // EDIT LOAD
        $(document).on('click', '.editBookingBtn', function() {
            let id = $(this).data('id');
            let tripId = $(this).data('trip');

            $.get(`/admin/bookings/edit/${id}`, data => {
                $('#bookingEditId').val(data.id);
                $('#edit_passenger_name').val(data.passenger_name);
                $('#edit_passenger_phone').val(data.passenger_phone);
                $('#edit_trip').val(`${data.trip_name} (${data.trip_date})`);
                $('#edit_current_seat').val(data.seat_number);
                $('#bookingEditForm').attr('data-trip', tripId);
                $('#editSeatArea').html('');
                $('#bookingEditModal').modal('show');
            });
        });

        // UPDATE
        $(document).on('submit', '#bookingEditForm', function(e) {
            e.preventDefault();
            let id = $('#bookingEditId').val();

            $.post(`/admin/bookings/update/${id}`, $(this).serialize())
                .done(res => {
                    if (res.success) {
                        toastSuccess(res.message);
                        $('#bookingEditModal').modal('hide');
                        reloadBookingTable();
                    } else toastError(res.message);
                })
                .fail(handleValidationErrors);
        });

        // CHANGE SEAT
        $(document).on('click', '#changeSeatBtn', function() {
            let tripId = $('#bookingEditForm').data('trip');
            $('#editSeatArea').load(`/admin/bookings/seat-list/${tripId}`);
        });

        // VIEW
        $(document).on('click', '.viewBookingBtn', function() {
            openBookingShowModal($(this).data('id'));
        });

        // ============================
        // TABLE RELOAD (FINAL & SAFE)
        // ============================
        function reloadBookingTable() {

            bookingDataTable.clear().destroy();

            $.get(`/admin/bookings/list`, function(res) {
                $('#bookingTable').html(res.html);
                initBookingTable(); // re-init properly
            });
        }
    </script>
@endpush
