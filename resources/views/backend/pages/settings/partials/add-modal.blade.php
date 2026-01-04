<div class="modal fade" id="addSettingModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="addSettingForm" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5>Add New Setting</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Setting Label</label>
                        <input type="text" name="label" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Key (unique)</label>
                        <input type="text" name="key" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Group</label>
                        <select name="group" class="form-control">
                            <option value="booking">Booking</option>
                            <option value="general">General</option>
                            <option value="payment">Payment</option>
                            <option value="company">Company</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Type</label>
                        <select name="type" class="form-control" id="settingType">
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="image">Image</option>
                        </select>
                    </div>

                    <div class="mb-3" id="valueInputArea">
                        <label>Value</label>
                        <input type="text" name="value" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Save</button>
                </div>

            </form>

        </div>
    </div>
</div>