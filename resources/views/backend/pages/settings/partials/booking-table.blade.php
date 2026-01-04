<table class="table table-bordered table-striped" id="dataTable">
    <thead>
        <tr>
            <th>Setting</th>
            <th>Value</th>
            <th width="120">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bookingSettings as $setting)
            <tr>
                <td>{{ $setting->label }}</td>
                <td>
                    <form class="settingUpdateForm d-flex gap-2">
                        @csrf
                        <input type="hidden" name="key" value="{{ $setting->key }}">

                        @if ($setting->type === 'number')
                            <input type="number" name="value" value="{{ $setting->value }}"
                                   class="form-control form-control-sm">
                        @else
                            <input type="text" name="value" value="{{ $setting->value }}"
                                   class="form-control form-control-sm">
                        @endif

                        <button class="btn btn-sm btn-success">
                            Update
                        </button>
                    </form>
                </td>
                <td>
                    {{-- future: reset button, info icon, etc --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>