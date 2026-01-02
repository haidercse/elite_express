<div class="modal-header bg-warning text-white">
    <h5 class="modal-title">Edit Profile</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

    <form id="profileEditForm" enctype="multipart/form-data">
        @csrf

        <input type="hidden" id="edit_user_id" value="{{ $user->id }}">

        <div class="row g-3">

            {{-- PERSONAL INFO --}}
            <div class="col-12">
                <h6 class="fw-bold text-primary border-bottom pb-1">Personal Information</h6>
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ optional($user->profile)->phone }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Date of Birth</label>
                <input type="text" name="dob" class="form-control date-input"
                       placeholder="DD/MM/YYYY"
                       value="{{ optional($user->profile)->dob }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-control">
                    <option value="">Select</option>
                    <option value="Male" {{ optional($user->profile)->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ optional($user->profile)->gender == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control"
                       value="{{ optional($user->profile)->address }}">
            </div>

            {{-- IDENTITY INFO --}}
            <div class="col-12 mt-3">
                <h6 class="fw-bold text-primary border-bottom pb-1">Identity Information</h6>
            </div>

            <div class="col-md-6">
                <label class="form-label">NID Number</label>
                <input type="text" name="nid_number" class="form-control"
                       value="{{ optional($user->profile)->nid_number }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Passport Number</label>
                <input type="text" name="passport_number" class="form-control"
                       value="{{ optional($user->profile)->passport_number }}">
            </div>

            {{-- SALARY INFO --}}
            <div class="col-12 mt-3">
                <h6 class="fw-bold text-primary border-bottom pb-1">Salary Information</h6>
            </div>

            <div class="col-md-6">
                <label class="form-label">Salary</label>
                <input type="number" name="salary" class="form-control"
                       value="{{ optional($user->profile)->salary }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Salary Type</label>
                <select name="salary_type" class="form-control">
                    <option value="">Select</option>
                    <option value="Monthly" {{ optional($user->profile)->salary_type == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="Hourly" {{ optional($user->profile)->salary_type == 'Hourly' ? 'selected' : '' }}>Hourly</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Employment Type</label>
                <select name="employment_type" class="form-control">
                    <option value="">Select</option>
                    <option value="Full-Time" {{ optional($user->profile)->employment_type == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                    <option value="Part-Time" {{ optional($user->profile)->employment_type == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                    <option value="Contract" {{ optional($user->profile)->employment_type == 'Contract' ? 'selected' : '' }}>Contract</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Joining Date</label>
                <input type="text" name="joining_date" class="form-control date-input"
                       placeholder="DD/MM/YYYY"
                       value="{{ optional($user->profile)->joining_date }}">
            </div>

            {{-- DOCUMENTS --}}
            <div class="col-12 mt-3">
                <h6 class="fw-bold text-primary border-bottom pb-1">Documents</h6>
            </div>

            <div class="col-md-6">
                <label class="form-label">Profile Photo</label>
                <input type="file" name="profile_photo" class="form-control preview-image"
                       data-preview="#previewProfile">

                <img id="previewProfile"
                     src="{{ optional($user->profile)->profile_photo ? asset('uploads/profile/' . $user->profile->profile_photo) : '' }}"
                     class="img-fluid mt-2 rounded" width="120">
            </div>

            <div class="col-md-6">
                <label class="form-label">NID Document</label>
                <input type="file" name="nid_document" class="form-control preview-image"
                       data-preview="#previewNid">

                <img id="previewNid"
                     src="{{ optional($user->profile)->nid_document ? asset('uploads/nid/' . $user->profile->nid_document) : '' }}"
                     class="img-fluid mt-2 rounded" width="120">
            </div>

            <div class="col-md-6">
                <label class="form-label">Contract Document</label>
                <input type="file" name="contract_document" class="form-control preview-image"
                       data-preview="#previewContract">

                <img id="previewContract"
                     src="{{ optional($user->profile)->contract_document ? asset('uploads/contracts/' . $user->profile->contract_document) : '' }}"
                     class="img-fluid mt-2 rounded" width="120">
            </div>

        </div>

        <button type="submit" class="btn btn-success w-100 mt-4">Update Profile</button>

    </form>

</div>