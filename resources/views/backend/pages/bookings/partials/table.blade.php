@forelse ($bookings as $booking)
    <tr>
        <td>{{ $booking->booking_code }}</td>
        <td>{{ $booking->passenger_name }}</td>
        <td>
            @if ($booking->trip && $booking->trip->route)
                {{ $booking->trip->route->from_city }} → {{ $booking->trip->route->to_city }}
            @else
                -
            @endif
        </td>
        <td>{{ $booking->seat->seat_number ?? '-' }}</td>
        <td>{{ $booking->total_amount }}</td>
        <td>
            <span class="badge bg-info">{{ ucfirst($booking->status) }}</span>
        </td>
        <td>
            <span class="badge bg-success">{{ ucfirst($booking->payment_status) }}</span>
        </td>
        <td style="white-space: nowrap;">
            <button type="button" class="btn btn-sm btn-warning editBookingBtn" data-id="{{ $booking->id }}"
                data-trip="{{ $booking->trip_id }}">
                Edit
            </button>

            <button type="button" class="btn btn-sm btn-primary viewBookingBtn" data-id="{{ $booking->id }}">
                View
            </button>
            <button type="button" class="btn btn-sm btn-dark cancelBookingBtn" data-id="{{ $booking->id }}">
                Cancel
            </button>
            <button type="button" class="btn btn-sm btn-danger deleteBookingBtn" data-id="{{ $booking->id }}">
                Delete
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">No bookings found</td>
    </tr>
@endforelse
