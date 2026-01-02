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
                @include('backend.pages.users.partials.table')
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
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                                class="role-checkbox">
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

            // Add User
            $('#addUserBtn').click(function() {
                $('#modalTitle').text("Add User");
                $('#userForm')[0].reset();
                $('#user_id').val('');
                $('.role-checkbox').prop('checked', false);
                $('#saveBtn').removeClass('btn-warning').addClass('btn-success').text("Save");
                $('#userModal').modal('show');
            });

            // Save / Update User
            $('#userForm').submit(function(e) {
                e.preventDefault();

                let id = $('#user_id').val();
                let url = id ? `/admin/users/update/${id}` : `/admin/users/store`;

                let formData = {
                    id: $('#user_id').val(),
                    name: $('#name').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    status: $('#status').val(),
                    roles: $('input[name="roles[]"]:checked').map(function() {
                        return $(this).val();
                    }).get(),
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    success: function() {
                        $('#userModal').modal('hide');
                        reloadTable();
                        toastSuccess("User saved successfully!");
                    },
                    error: function() {
                        toastError("Something went wrong!");
                    }
                });
            });

            // Edit User
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

            // Delete User
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
                        toastSuccess("User deleted successfully!");
                    },
                    error: function() {
                        toastError("Failed to delete!");
                    }
                });
            });

            // View Profile
            $(document).on('click', '.view-profile', function() {
                let id = $(this).data('id');

                $.get(`/admin/users/profile-modal/${id}`, function(html) {
                    $('#dynamicProfileModal .modal-content').html(html);
                    $('#dynamicProfileModal').modal('show');
                });
            });

            // Date Input Mask
            $(document).on('input', '.date-input', function() {
                let v = $(this).val();
                v = v.replace(/[^0-9\/]/g, '');
                if (v.length === 2 || v.length === 5) {
                    if (!v.endsWith('/')) v += '/';
                }
                $(this).val(v);
            });

            // Edit Profile
            $(document).on('click', '.edit-profile', function() {
                let id = $(this).data('id');

                $.get(`/admin/users/profile-edit-modal/${id}`, function(html) {
                    $('#dynamicProfileModal .modal-content').html(html);
                    $('#dynamicProfileModal').modal('show');
                });
            });

            // Update Profile
            $(document).on('submit', '#profileEditForm', function(e) {
                e.preventDefault();

                let id = $('#edit_user_id').val();
                let formData = new FormData(this);

                // Phone validation
                let phone = $('input[name="phone"]').val();
                if (phone && phone.length !== 11) {
                    toastError("Bangladesh phone number must be 11 digits");
                    return;
                }

                // Date formatting using global helper
                formData.set('dob', formatDate($('input[name="dob"]').val()));
                formData.set('joining_date', formatDate($('input[name="joining_date"]').val()));

                $.ajax({
                    url: `/admin/users/profile-update/${id}`,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function() {
                        $('#dynamicProfileModal').modal('hide');
                        toastSuccess("Profile updated successfully!");
                        reloadTable();
                    },
                    error: function(xhr) {
                        handleValidationErrors(xhr);
                    }

                });
            });

            // Image Preview (Global Helper)
            $(document).on('change', '.preview-image', function() {
                previewImage(this, $(this).data('preview'));
            });

            // Reload Table
            function reloadTable() {
                $.get(`/admin/users/list`, function(html) {
                    $('#userTableWrapper').html(html);
                });
            }

        });
    </script>
@endpush
