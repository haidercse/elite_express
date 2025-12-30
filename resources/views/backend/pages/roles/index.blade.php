@extends('backend.layouts.master')

@section('title', 'Manage Roles')

@section('admin-content')
    <div class="container my-4">
        <h3 class="mb-4 text-primary fw-bold text-center">Role Management</h3>

        <div id="alertBox"></div>

        <div class="text-end mb-3">
            <button class="btn btn-success" id="addRoleBtn">Add New Role</button>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Roles</div>
            <div class="card-body" id="roleTableWrapper">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr id="role-{{ $role->id }}">
                                <td>{{ $role->name }}</td>
                                <td>{{ implode(', ', $role->permissions->pluck('name')->toArray()) }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-role"
                                        data-id="{{ $role->id }}">Edit</button>
                                    <button class="btn btn-danger btn-sm delete-role"
                                        data-id="{{ $role->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="roleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalTitle">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="roleForm">
                        @csrf
                        <input type="hidden" id="role_id">

                        <div class="mb-3">
                            <label class="fw-semibold">Role Name</label>
                            <input type="text" id="role_name" class="form-control" placeholder="Enter role name"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Permissions</label>

                            <!-- Select All Checkbox -->
                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                                <label class="form-check-label fw-bold text-primary" for="selectAll">
                                    Select All Permissions
                                </label>
                            </div>

                            <!-- Permission Groups -->
                            @foreach ($permissions as $group => $perms)
                                <div class="mb-4">
                                    <!-- Group Name with Checkbox -->
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input group-check"
                                            id="group-{{ $group }}" data-group="{{ $group }}">
                                        <label class="form-check-label fw-bold" for="group-{{ $group }}">
                                            {{ ucwords(str_replace(['-', '_'], ' ', $group)) }}
                                            <!-- menu → Menu, dough-making-table-update → Dough Making Table Update -->
                                        </label>
                                    </div>

                                    <!-- Child Permissions in 2 columns -->
                                    <div class="row ms-4">
                                        @foreach ($perms as $perm)
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input perm-checkbox"
                                                        name="permissions[]" value="{{ $perm->name }}"
                                                        data-group="{{ $group }}" id="perm-{{ $perm->id }}">
                                                    <label class="form-check-label" for="perm-{{ $perm->id }}">
                                                        {{ $perm->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold">SAVE ROLE</button>
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
                let cls = type === 'success' ? 'alert-success' : 'alert-danger';
                $('#alertBox').html(
                    `<div class="alert ${cls} alert-dismissible fade show">${message}<button class="btn-close" data-bs-dismiss="alert"></button></div>`
                    );
            }

            $('#addRoleBtn').click(function() {
                $('#modalTitle').text('Add Role');
                $('#roleForm')[0].reset();
                $('#role_id').val('');
                $('.perm-checkbox, .group-check, #selectAll').prop('checked', false).prop('indeterminate',
                    false);
                $('#roleModal').modal('show');
            });

            // 1. Select All - Master Toggle
            $('#selectAll').on('change', function() {
                let isChecked = this.checked;
                $('.perm-checkbox, .group-check').prop('checked', isChecked).prop('indeterminate', false);
            });

            // 2. Group checkbox - toggle all children
            $(document).on('change', '.group-check', function() {
                let groupName = $(this).data('group');
                $(`.perm-checkbox[data-group="${groupName}"]`).prop('checked', this.checked);
                updateSelectAll();
            });

            // 3. Child checkbox - update parent group + master
            $(document).on('change', '.perm-checkbox', function() {
                let groupName = $(this).data('group');
                let total = $(`.perm-checkbox[data-group="${groupName}"]`).length;
                let checked = $(`.perm-checkbox[data-group="${groupName}"]:checked`).length;

                let groupCheck = $(`#group-${groupName}`);
                if (checked === total) {
                    groupCheck.prop('checked', true).prop('indeterminate', false);
                } else if (checked === 0) {
                    groupCheck.prop('checked', false).prop('indeterminate', false);
                } else {
                    groupCheck.prop('checked', false).prop('indeterminate', true);
                }

                updateSelectAll();
            });

            // Update Select All checkbox state
            function updateSelectAll() {
                let totalPerms = $('.perm-checkbox').length;
                let checkedPerms = $('.perm-checkbox:checked').length;

                if (checkedPerms === totalPerms && totalPerms > 0) {
                    $('#selectAll').prop('checked', true).prop('indeterminate', false);
                } else if (checkedPerms === 0) {
                    $('#selectAll').prop('checked', false).prop('indeterminate', false);
                } else {
                    $('#selectAll').prop('checked', false).prop('indeterminate', true);
                }
            }

            // Edit Role
            $(document).on('click', '.edit-role', function() {
                let id = $(this).data('id');
                $.get(`/admin/roles/${id}/permissions`, function(res) {
                    $('#modalTitle').text('Edit Role');
                    $('#role_id').val(res.role.id);
                    $('#role_name').val(res.role.name);

                    $('.perm-checkbox, .group-check, #selectAll').prop('checked', false).prop(
                        'indeterminate', false);

                    res.assigned.forEach(function(p) {
                        $(`.perm-checkbox[value="${p}"]`).prop('checked', true);
                    });

                    // Update group states
                    $('.group-check').each(function() {
                        let g = $(this).data('group');
                        let total = $(`.perm-checkbox[data-group="${g}"]`).length;
                        let checked = $(`.perm-checkbox[data-group="${g}"]:checked`).length;
                        if (checked === total && total > 0) {
                            $(this).prop('checked', true).prop('indeterminate', false);
                        } else if (checked === 0) {
                            $(this).prop('checked', false).prop('indeterminate', false);
                        } else {
                            $(this).prop('checked', false).prop('indeterminate', true);
                        }
                    });

                    updateSelectAll();
                    $('#roleModal').modal('show');
                });
            });

            // Save Role
            $('#roleForm').submit(function(e) {
                e.preventDefault();
                let id = $('#role_id').val();
                let url = id ? `/admin/roles/update/${id}` : "{{ route('admin.roles.store.ajax') }}";

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        name: $('#role_name').val(),
                        permissions: $('input[name="permissions[]"]:checked').map(function() {
                            return this.value;
                        }).get(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        $('#roleModal').modal('hide');
                        showAlert('success', res.message);
                        reloadTable();
                    }
                });
            });

            // Delete Role
            $(document).on('click', '.delete-role', function() {
                if (!confirm('Delete this role?')) return;
                let id = $(this).data('id');
                $.ajax({
                    url: `/admin/roles/delete/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        $(`#role-${id}`).remove();
                        showAlert('success', res.message);
                    }
                });
            });

            function reloadTable() {
                $.get("{{ route('admin.roles.index') }}", function(data) {
                    $('#roleTableWrapper').html($(data).find('#roleTableWrapper').html());
                });
            }
        });
    </script>
@endpush
