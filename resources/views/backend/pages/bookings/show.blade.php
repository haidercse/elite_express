<div>
    <p><strong>Booking Code:</strong> {{ $booking->booking_code }}</p>

    <p><strong>Passenger:</strong> {{ $booking->passenger_name }}</p>
    <p><strong>Phone:</strong> {{ $booking->passenger_phone }}</p>

    <p><strong>Trip:</strong>
        @if ($booking->trip && $booking->trip->route)
            {{ $booking->trip->route->from_city }} →
            {{ $booking->trip->route->to_city }}
            ({{ $booking->trip->date }})
        @else
            -
        @endif
    </p>

    <p><strong>Seat:</strong> {{ $booking->seat->seat_number ?? '-' }}</p>

    <p><strong>Fare:</strong> {{ $booking->fare }}</p>
    <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
    <p><strong>Payment:</strong> {{ ucfirst($booking->payment_status) }}</p>
</div>
