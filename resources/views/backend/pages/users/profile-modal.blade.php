<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">User Profile</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    <div class="row">

        {{-- LEFT SIDEBAR --}}
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">

                    @php
                        $photo = optional($user->profile)->profile_photo
                            ? asset('uploads/profile/' . $user->profile->profile_photo)
                            : 'https://via.placeholder.com/150';
                    @endphp

                    <img src="{{ $photo }}" class="rounded-circle mb-3" width="150" height="150">

                    <h4 class="fw-bold">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>

                    @if ($user->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif

                    <hr>

                    <h6 class="fw-bold">Roles</h6>
                    @foreach ($user->roles as $role)
                        <span class="badge bg-primary">{{ $role->name }}</span>
                    @endforeach

                </div>

                {{-- EDIT BUTTON --}}
                <button class="btn btn-warning edit-profile w-100" data-id="{{ $user->id }}">
                    Edit Profile
                </button>

            </div>
        </div>

        {{-- RIGHT CONTENT --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    {{-- TABS --}}
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personalTab">Personal</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#identityTab">Identity</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#salaryTab">Salary</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#documentsTab">Documents</button>
                        </li>
                    </ul>

                    <div class="tab-content">

                        {{-- PERSONAL --}}
                        <div class="tab-pane fade show active" id="personalTab">
                            <table class="table table-bordered">
                                <tr><th>Phone</th><td>{{ optional($user->profile)->phone ?? 'N/A' }}</td></tr>
                                <tr><th>DOB</th><td>{{ optional($user->profile)->dob ?? 'N/A' }}</td></tr>
                                <tr><th>Gender</th><td>{{ optional($user->profile)->gender ?? 'N/A' }}</td></tr>
                                <tr><th>Address</th><td>{{ optional($user->profile)->address ?? 'N/A' }}</td></tr>
                            </table>
                        </div>

                        {{-- IDENTITY --}}
                        <div class="tab-pane fade" id="identityTab">
                            <table class="table table-bordered">
                                <tr><th>NID</th><td>{{ optional($user->profile)->nid_number ?? 'N/A' }}</td></tr>
                                <tr><th>Passport</th><td>{{ optional($user->profile)->passport_number ?? 'N/A' }}</td></tr>
                            </table>
                        </div>

                        {{-- SALARY --}}
                        <div class="tab-pane fade" id="salaryTab">
                            <table class="table table-bordered">
                                <tr><th>Salary</th><td>{{ optional($user->profile)->salary ?? 'N/A' }}</td></tr>
                                <tr><th>Type</th><td>{{ optional($user->profile)->salary_type ?? 'N/A' }}</td></tr>
                                <tr><th>Employment</th><td>{{ optional($user->profile)->employment_type ?? 'N/A' }}</td></tr>
                                <tr><th>Joining</th><td>{{ optional($user->profile)->joining_date ?? 'N/A' }}</td></tr>
                            </table>
                        </div>

                        {{-- DOCUMENTS --}}
                        <div class="tab-pane fade" id="documentsTab">
                            <table class="table table-bordered">
                                <tr>
                                    <th>NID</th>
                                    <td>
                                        @if(optional($user->profile)->nid_document)
                                            <a href="{{ asset('uploads/nid/' . $user->profile->nid_document) }}" target="_blank" class="btn btn-primary btn-sm">View</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Contract</th>
                                    <td>
                                        @if(optional($user->profile)->contract_document)
                                            <a href="{{ asset('uploads/contracts/' . $user->profile->contract_document) }}" target="_blank" class="btn btn-primary btn-sm">View</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>