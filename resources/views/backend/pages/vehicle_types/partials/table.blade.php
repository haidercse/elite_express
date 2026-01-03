@foreach($types as $type)
<tr>
    <td>{{ $type->name }}</td>
    <td>{{ $type->seat_count }}</td>
    <td>
        <span class="badge {{ $type->status ? 'bg-success' : 'bg-danger' }}">
            {{ $type->status ? 'Active' : 'Inactive' }}
        </span>
    </td>
    <td>
        @can('vehicle-type.edit')
        <button class="btn btn-sm btn-primary editBtn" data-id="{{ $type->id }}">
            Edit
        </button>
        @endcan

        @can('vehicle-type.delete')
        <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $type->id }}">
            Delete
        </button>
        @endcan
    </td>
</tr>
@endforeach