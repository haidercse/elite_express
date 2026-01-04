<div class="modal fade" id="bookingEditModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="bookingEditForm">
                @csrf
                <input type="hidden" id="bookingEditId">

                <div class="modal-header">
                    <h5>Edit Booking</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Trip</label>
                        <input type="text" id="edit_trip" class="form-control" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Current Seat</label>
                        <input type="text" id="edit_current_seat" class="form-control" disabled>
                    </div>

                    <button type="button" class="btn btn-secondary mb-3" id="changeSeatBtn">
                        Change Seat
                    </button>

                    <div id="editSeatArea"></div>

                    <div class="mb-3">
                        <label>Passenger Name</label>
                        <input type="text" id="edit_passenger_name" name="passenger_name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Passenger Phone</label>
                        <input type="text" id="edit_passenger_phone" name="passenger_phone" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>