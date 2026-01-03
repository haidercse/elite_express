@foreach ($trips as $trip)
    <tr>
        <td>{{ $trip->trip_code }}</td>
        <td>{{ $trip->route->from_city }} → {{ $trip->route->to_city }}</td>
        <td>{{ $trip->vehicle->name }} ({{ $trip->vehicle->plate_number }})</td>
        <td>{{ $trip->date }}</td>
        <td>{{ $trip->departure_time }}</td>
        <td>{{ $trip->arrival_time ?? '-' }}</td>
        <td>{{ number_format($trip->base_fare, 2) }}</td>
        <td>
            <span
                class="badge 
            @if ($trip->status == 'scheduled') bg-info 
            @elseif($trip->status == 'completed') bg-success 
            @else bg-danger @endif">
                {{ ucfirst($trip->status) }}
            </span>
        </td>
        <td>
            @can('trip.edit')
                <button class="btn btn-sm btn-primary editBtn" data-id="{{ $trip->id }}">
                    Edit
                </button>
            @endcan

            @can('trip.delete')
                <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $trip->id }}">
                    Delete
                </button>
            @endcan
        </td>
    </tr>
@endforeach
