<div class="modal fade" id="bookingCancelModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="bookingCancelForm">
                @csrf
                <input type="hidden" id="cancel_booking_id">

                <div class="modal-header">
                    <h5>Cancel Booking</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <p><strong>Total Fare:</strong> <span id="cancel_total"></span></p>
                    <p><strong>Cancellation Fee:</strong> <span id="cancel_fee"></span></p>
                    <p><strong>Refund Amount:</strong> <span id="cancel_refund"></span></p>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger">Confirm Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>
