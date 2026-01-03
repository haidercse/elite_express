@foreach ($seats as $seat)
    <tr>
        <td>{{ $seat->vehicle->name }} ({{ $seat->vehicle->plate_number }})</td>
        <td>{{ $seat->seat_number }}</td>
        <td>{{ $seat->seat_label ?? '-' }}</td>
        <td>{{ ucfirst($seat->seat_type) }}</td>
        <td>{{ ucfirst($seat->seat_category) }}</td>
        <td>{{ $seat->base_fare_multiplier }}</td>
        <td>{{ $seat->position_row }}</td>
        <td>{{ $seat->position_column }}</td>

        <td>
            @can('seat.edit')
                <button class="btn btn-sm btn-primary editBtn" data-id="{{ $seat->id }}">
                    Edit
                </button>
            @endcan

            @can('seat.delete')
                <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $seat->id }}">
                    Delete
                </button>
            @endcan
        </td>
    </tr>
@endforeach
