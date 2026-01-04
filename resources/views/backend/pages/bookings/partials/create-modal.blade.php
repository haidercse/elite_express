<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="bookingForm">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Create Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Trip</label>
                        <select id="trip_id" name="trip_id" class="form-control">
                            <option value="">Select Trip</option>
                            @foreach ($trips as $trip)
                                <option value="{{ $trip->id }}">
                                    {{ $trip->route->from_city ?? '' }} →
                                    {{ $trip->route->to_city ?? '' }}
                                    ({{ $trip->date }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="seatArea"></div>

                    <div class="mb-3">
                        <label>Passenger Name</label>
                        <input type="text" name="passenger_name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Passenger Phone</label>
                        <input type="text" name="passenger_phone" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>