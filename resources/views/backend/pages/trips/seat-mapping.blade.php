@extends('backend.layouts.master')

@section('title', 'Seat Mapping')

@section('admin-content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>
                Seat Mapping —
                <span class="text-primary">{{ $trip->trip_code ?? 'TRIP-' . $trip->id }}</span>
            </h4>

            <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Back to Trips
            </a>
        </div>

        {{-- Trip Info --}}
        <div class="card mb-3">
            <div class="card-body">
                <strong>Route:</strong> {{ $trip->route->from_city }} → {{ $trip->route->to_city }} <br>
                <strong>Vehicle:</strong> {{ $trip->vehicle->name }} ({{ $trip->vehicle->plate_number }}) <br>
                <strong>Date:</strong> {{ $trip->date }} <br>
                <strong>Base Fare:</strong> {{ $trip->base_fare }} <br>
            </div>
        </div>

        {{-- Legend --}}
        <div class="card mb-3">
            <div class="card-body d-flex gap-4">
                <div><span class="legend-box bg-success"></span> Available</div>
                <div><span class="legend-box bg-danger"></span> Booked</div>
                <div><span class="legend-box bg-warning"></span> Reserved</div>
                <div><span class="legend-box bg-secondary"></span> Blocked</div>
            </div>
        </div>

        {{-- Seat Layout --}}
        <div class="card">
            <div class="card-body">

                <h5 class="mb-3">Seat Layout</h5>

                <div class="seat-grid">
                    @foreach ($seats as $map)
                        @php
                            $seat = $map->seat;
                            $status = $map->status;

                            $color = match ($status) {
                                'available' => 'bg-success',
                                'booked' => 'bg-danger',
                                'reserved' => 'bg-warning',
                                'blocked' => 'bg-secondary',
                                default => 'bg-light',
                            };
                        @endphp

                        <div class="seat-box {{ $color }}" data-id="{{ $map->id }}"
                            data-status="{{ $status }}" data-seat="{{ $seat->seat_number }}"
                            title="{{ $seat->seat_number }} ({{ ucfirst($status) }})">
                            {{ $seat->seat_number }}
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>

@endsection

@push('styles')
    <style>
        .seat-grid {
            display: grid;
            grid-template-columns: repeat(4, 80px);
            gap: 12px;
            justify-content: center;
            margin-top: 20px;
        }

        .seat-box {
            width: 80px;
            height: 60px;
            border-radius: 6px;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .seat-box:hover {
            transform: scale(1.05);
            opacity: 0.9;
        }

        .legend-box {
            width: 20px;
            height: 20px;
            display: inline-block;
            border-radius: 4px;
            margin-right: 6px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Seat Click Handler
        $(document).on('click', '.seat-box', function() {
            let id = $(this).data('id');
            let status = $(this).data('status');
            let seat = $(this).data('seat');

            Swal.fire({
                title: `Seat: ${seat}`,
                text: "Change seat status",
                icon: "info",
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: "Book",
                denyButtonText: "Reserve",
                cancelButtonText: "Block"
            }).then((result) => {

                let newStatus = null;

                if (result.isConfirmed) newStatus = "booked";
                else if (result.isDenied) newStatus = "reserved";
                else if (result.dismiss === Swal.DismissReason.cancel) newStatus = "blocked";

                if (newStatus) {
                    updateSeatStatus(id, newStatus);
                }
            });
        });

        function updateSeatStatus(id, status) {
            $.ajax({
                url: "{{ url('admin/trips/seat-status/update') }}/" + id,
                method: "POST",
                data: {
                    status: status,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.success) {
                        toastSuccess(res.message);
                        location.reload();
                    } else {
                        toastError("Failed to update seat");
                    }
                },
                error: function() {
                    toastError("Server error");
                }
            });
        }
    </script>
@endpush
