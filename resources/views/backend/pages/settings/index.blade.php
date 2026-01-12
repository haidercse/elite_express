@extends('backend.layouts.master')

@section('title', 'Settings')

@section('admin-content')
    <div class="container-fluid">

        <h4 class="mb-3">System Settings</h4>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Booking Settings</strong>

                <button class="btn btn-primary btn-sm" id="addSettingBtn">
                    <i class="fa fa-plus"></i> Add Setting
                </button>
            </div>
            @include('backend.pages.settings.partials.add-modal')
            @include('backend.pages.settings.partials.booking-table', ['settings' => $settings])

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // reload booking settings table (if needed later)
        window.reloadBookingSettings = function() {
            $.get("{{ route('admin.settings.list') }}", function(res) {
                $('#bookingSettingsTable').html(res);
            });
        }

        $(document).on('change', '#settingType', function() {
            let type = $(this).val();

            if (type === 'image') {
                $('#valueInputArea').html(`
            <label>Upload Image</label>
            <input type="file" name="value" class="form-control">
        `);
            } else {
                $('#valueInputArea').html(`
            <label>Value</label>
            <input type="${type}" name="value" class="form-control">
        `);
            }
        });
        //show add form modal
        $(document).on('click', '#addSettingBtn', function() {
            $('#addSettingForm')[0].reset();
            $('#addSettingModal').modal('show');
        });
        $(document).on('submit', '#addSettingForm', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.settings.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: "success",
                            title: res.message,
                            timer: 1500,
                            showConfirmButton: false,
                        });

                        $('#addSettingModal').modal('hide');
                        reloadBookingSettings();
                    } else {
                        Swal.fire("Error", res.message ?? "Failed", "error");
                    }
                },
                error: function() {
                    Swal.fire("Error", "Something went wrong", "error");
                }
            });
        });

        // inline update submit (AJAX)

        $(document).on('submit', '.settingUpdateForm', function(e) {
            e.preventDefault();

            let form = $(this);
            let formData = new FormData(form[0]);

            $.ajax({
                url: "{{ route('admin.settings.update') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: "success",
                            title: res.message,
                            timer: 1500,
                            showConfirmButton: false,
                        });

                        // reload page or reload table
                        location.reload();
                    }
                }
            });
        });
    </script>
@endpush
