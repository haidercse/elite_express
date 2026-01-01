@extends('backend.layouts.master')

@section('title', 'Manage Users')

@section('admin-content')
<div class="container my-4">

    <h3 class="mb-4 text-primary fw-bold text-center">User Management</h3>

    <div id="alertBox" class="mt-2"></div>

    <div class="mb-3 text-end">
        <button class="btn btn-success" id="addUserBtn">Add New User</button>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">User Records</div>
        <div class="card-body" id="userTableWrapper">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
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
                                    <button class="btn btn-sm btn-warning edit-user"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-status="{{ $user->status }}"
                                        data-roles="{{ $user->roles->pluck('id') }}">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <button class="btn btn-sm btn-danger delete-user"
                                        data-id="{{ $user->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTitle">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="userForm">
                    @csrf
                    <input type="hidden" id="user_id" name="id">

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="text-muted">Leave blank if not changing</small>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    {{-- Roles --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Assign Roles</label>
                        <div class="row">
                            @foreach ($roles as $role)
                                <div class="col-6">
                                    <label>
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="role-checkbox">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100" id="saveBtn">Save</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    function showAlert(type, message) {
        let alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        $('#alertBox').html(`
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        setTimeout(() => $('.alert').alert('close'), 4000);
    }

    // Add Button
    $('#addUserBtn').click(function() {
        $('#modalTitle').text("Add User");
        $('#userForm')[0].reset();
        $('#user_id').val('');
        $('.role-checkbox').prop('checked', false);

        $('#saveBtn').removeClass('btn-warning').addClass('btn-success').text("Save");
        $('#userModal').modal('show');
    });

    // Save / Update
    $('#userForm').submit(function(e) {
        e.preventDefault();

        let id = $('#user_id').val();
        let url = id ? `/admin/users/update/${id}` : `/admin/users/store`;

        $.ajax({
            url: url,
            method: "POST",
            data: $(this).serialize(),
            success: function() {
                $('#userModal').modal('hide');
                reloadTable();
                showAlert('success', "User saved successfully!");
            },
            error: function() {
                showAlert('error', "Something went wrong!");
            }
        });
    });

    // Edit
    $(document).on('click', '.edit-user', function() {
        $('#modalTitle').text("Edit User");

        $('#user_id').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#email').val($(this).data('email'));
        $('#status').val($(this).data('status'));

        $('.role-checkbox').prop('checked', false);

        let roles = $(this).data('roles');
        roles.forEach(id => {
            $(`.role-checkbox[value="${id}"]`).prop('checked', true);
        });

        $('#saveBtn').removeClass('btn-success').addClass('btn-warning').text("Update");

        $('#userModal').modal('show');
    });

    // Delete
    $(document).on('click', '.delete-user', function() {
        if (!confirm("Are you sure to delete?")) return;

        let id = $(this).data('id');

        $.ajax({
            url: `/admin/users/delete/${id}`,
            method: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function() {
                $(`#user-${id}`).remove();
                showAlert('success', "User deleted successfully!");
            },
            error: function() {
                showAlert('error', "Failed to delete!");
            }
        });
    });

    // Reload Table
    function reloadTable() {
        $.get(`/admin/users`, function(data) {
            $('#userTableWrapper').html($(data).find('#userTableWrapper').html());
        });
    }

});
</script>
@endpush