@foreach ($routes as $route)
    <tr>
        <td>{{ $route->from_city }}</td>
        <td>{{ $route->to_city }}</td>
        <td>{{ $route->distance_km ?? '-' }}</td>
        <td>{{ $route->approx_duration_minutes ?? '-' }}</td>
        <td>
            <span class="badge {{ $route->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                {{ ucfirst($route->status) }}
            </span>
        </td>
        <td>
            @can('route.edit')
                <button class="btn btn-sm btn-primary editBtn" data-id="{{ $route->id }}">
                    Edit
                </button>
            @endcan

            @can('route.delete')
                <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $route->id }}">
                    Delete
                </button>
            @endcan
        </td>
    </tr>
@endforeach
