<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Trip;
use App\Models\TripSeatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // ============================
    // INDEX PAGE
    // ============================
    public function index()
    {
        $bookings = Booking::with(['trip.route', 'seat'])->latest()->get();
        $trips = Trip::with('route')->latest()->get();

        return view('backend.pages.bookings.index', compact('bookings', 'trips'));
    }

    // ============================
    // AJAX: RELOAD TABLE
    // ============================
    public function list()
    {
        $bookings = Booking::with(['trip.route', 'seat'])->latest()->get();
        return response()->json([
            'html' => view('backend.pages.bookings.partials.table', compact('bookings'))->render()
        ]);

    }


    // ============================
    // AJAX: LOAD SEAT LIST FOR TRIP
    // ============================
    public function seatList($tripId)
    {
        $seats = TripSeatStatus::with('seat')
            ->where('trip_id', $tripId)
            ->get();

        return view('backend.pages.bookings.partials.seat-list', compact('seats'))->render();
    }

    // ============================
    // STORE BOOKING (AJAX)
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'seat_id' => 'required|exists:seats,id',
            'passenger_name' => 'required|string|max:255',
            'passenger_phone' => 'required|string|max:20',
        ]);

        // Check seat availability
        $seatStatus = TripSeatStatus::where('trip_id', $request->trip_id)
            ->where('seat_id', $request->seat_id)
            ->first();

        if (!$seatStatus || $seatStatus->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'Seat is not available'
            ]);
        }

        // Create booking
        Booking::create([
            'user_id' => auth()->id(),
            'trip_id' => $request->trip_id,
            'seat_id' => $request->seat_id,
            'passenger_name' => $request->passenger_name,
            'passenger_phone' => $request->passenger_phone,
            'fare' => $seatStatus->fare,
            'total_amount' => $seatStatus->fare,
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'booking_code' => $this->generateCode(),
        ]);

        // Update seat status
        $seatStatus->update(['status' => 'booked']);

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully'
        ]);
    }

    // ============================
    // SHOW BOOKING DETAILS (MODAL)
    // ============================
    public function show($id)
    {
        $booking = Booking::with(['trip.route', 'seat'])->findOrFail($id);
        return view('backend.pages.bookings.show', compact('booking'));
    }

    // ============================
    // EDIT BOOKING (LOAD MODAL DATA)
    // ============================
    public function edit($id)
    {
        $booking = Booking::with(['trip.route', 'seat'])->findOrFail($id);

        return response()->json([
            'id' => $booking->id,
            'passenger_name' => $booking->passenger_name,
            'passenger_phone' => $booking->passenger_phone,

            // Trip info
            'trip_name' => $booking->trip->route->from_city . ' → ' . $booking->trip->route->to_city,
            'trip_date' => $booking->trip->date,

            // Seat info
            'seat_number' => $booking->seat->seat_number,
            'seat_id' => $booking->seat_id,
        ]);
    }

    // ============================
    // UPDATE BOOKING (AJAX)
    // ============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'passenger_name' => 'required|string|max:255',
            'passenger_phone' => 'required|string|max:20',
            'seat_id' => 'nullable|exists:seats,id',
        ]);


        $booking = Booking::findOrFail($id);

        $oldSeat = $booking->seat_id;
        $newSeat = $request->seat_id ?? null;

        // If seat changed
        if ($newSeat && $newSeat != $oldSeat) {

            // Free old seat
            TripSeatStatus::where('trip_id', $booking->trip_id)
                ->where('seat_id', $oldSeat)
                ->update(['status' => 'available']);

            // Check new seat availability
            $seatStatus = TripSeatStatus::where('trip_id', $booking->trip_id)
                ->where('seat_id', $newSeat)
                ->first();

            if ($seatStatus->status !== 'available') {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected seat is not available'
                ]);
            }

            // Book new seat
            $seatStatus->update(['status' => 'booked']);

            // Update booking seat
            $booking->seat_id = $newSeat;
            $booking->fare = $seatStatus->fare;
            $booking->total_amount = $seatStatus->fare;
        }

        // Update passenger info
        $booking->update([
            'passenger_name' => $request->passenger_name,
            'passenger_phone' => $request->passenger_phone,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully'
        ]);
    }

    // ============================
    // DELETE BOOKING (AJAX)
    // ============================
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        // Free the seat
        TripSeatStatus::where('trip_id', $booking->trip_id)
            ->where('seat_id', $booking->seat_id)
            ->update(['status' => 'available']);

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully'
        ]);
    }

    // ============================
    // GENERATE UNIQUE BOOKING CODE
    // ============================
    private function generateCode()
    {
        do {
            $code = 'BK-' . strtoupper(Str::random(6));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }
    //cancel info and cancel functions
    public function cancelInfo($id)
    {
        $booking = Booking::findOrFail($id);

        $percent = setting('cancellation_fee_percent', 10);
        $min = setting('cancellation_min_fee', 0);
        $max = setting('cancellation_max_fee', 0);

        $fee = ($booking->total_amount * $percent) / 100;

        if ($min > 0 && $fee < $min)
            $fee = $min;
        if ($max > 0 && $fee > $max)
            $fee = $max;

        $refund = $booking->total_amount - $fee;

        return response()->json([
            'id' => $booking->id,
            'total_amount' => $booking->total_amount,
            'cancellation_fee' => $fee,
            'refund_amount' => $refund,
        ]);
    }
    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $percent = setting('cancellation_fee_percent', 10);
        $min = setting('cancellation_min_fee', 0);
        $max = setting('cancellation_max_fee', 0);

        $fee = ($booking->total_amount * $percent) / 100;

        if ($min > 0 && $fee < $min)
            $fee = $min;
        if ($max > 0 && $fee > $max)
            $fee = $max;

        $refund = $booking->total_amount - $fee;

        // Free seat
        TripSeatStatus::where('trip_id', $booking->trip_id)
            ->where('seat_id', $booking->seat_id)
            ->update(['status' => 'available']);

        // Update booking
        $booking->update([
            'status' => 'cancelled',
            'payment_status' => 'refunded',
            'cancellation_fee' => $fee,
            'refund_amount' => $refund,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking cancelled successfully'
        ]);
    }
}