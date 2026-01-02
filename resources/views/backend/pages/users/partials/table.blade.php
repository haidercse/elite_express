<div class="table-responsive">
    <table class="table table-bordered table-striped text-center" id="dataTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Status</th>
                <th width="150">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr id="user-{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        @foreach ($user->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>

                    <td>
                        @if ($user->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>

                    <td>
                        <div class="btn-group" role="group" style="gap: 4px;">

                            {{-- Edit --}}
                            <button class="btn btn-warning btn-sm edit-user" data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                data-status="{{ $user->status ? 1 : 0 }}" data-roles='@json($user->roles->pluck('id'))'>
                                <i class="fa fa-edit"></i>
                            </button>

                            {{-- Delete --}}
                            <button class="btn btn-danger btn-sm delete-user" data-id="{{ $user->id }}">
                                <i class="fa fa-trash"></i>
                            </button>

                            {{-- View Profile --}}
                            <button class="btn btn-info btn-sm view-profile" data-id="{{ $user->id }}">
                                <i class="fa fa-user"></i>
                            </button>


                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
