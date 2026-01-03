@foreach($vehicles as $vehicle)
<tr>
    <td>{{ $vehicle->type->name }}</td>
    <td>{{ $vehicle->name }}</td>
    <td>{{ $vehicle->plate_number }}</td>
    <td>{{ $vehicle->total_seats }}</td>
    <td>
        <span class="badge {{ $vehicle->status == 'active' ? 'bg-success' : 'bg-danger' }}">
            {{ ucfirst($vehicle->status) }}
        </span>
    </td>
    <td>
        @can('vehicle.edit')
        <button class="btn btn-sm btn-primary editBtn" data-id="{{ $vehicle->id }}">
            Edit
        </button>
        @endcan

        @can('vehicle.delete')
        <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $vehicle->id }}">
            Delete
        </button>
        @endcan
    </td>
</tr>
@endforeach