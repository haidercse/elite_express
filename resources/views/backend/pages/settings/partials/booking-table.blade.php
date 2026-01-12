<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Setting</th>
            <th>Value</th>
            <th width="120">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($settings as $setting)
            <tr>
                <td>
                    {{ $setting->label }}
                    <br>
                    <small class="text-muted">({{ $setting->group }})</small>
                </td>

                <td>
                    <form class="settingUpdateForm d-flex gap-2 align-items-center"
                          enctype="multipart/form-data">

                        @csrf
                        <input type="hidden" name="key" value="{{ $setting->key }}">
                        <input type="hidden" name="type" value="{{ $setting->type }}">

                        {{-- IMAGE TYPE --}}
                        @if ($setting->type === 'image')

                            {{-- CLICKABLE PREVIEW --}}
                            @if ($setting->value)
                                <img src="{{ asset('storage/' . $setting->value) }}"
                                     height="100"
                                     width="80"
                                     class="rounded border me-2 setting-image-preview"
                                     data-image="{{ asset('storage/' . $setting->value) }}"
                                     style="cursor:pointer;">
                            @endif

                            {{-- FILE INPUT WITH LIVE PREVIEW --}}
                            <input type="file"
                                   name="value"
                                   accept="image/*"
                                   class="form-control form-control-sm image-input"
                                   data-preview-target="#preview-{{ $setting->key }}">

                            {{-- LIVE PREVIEW IMAGE (hidden initially) --}}
                            <img id="preview-{{ $setting->key }}"
                                 src=""
                                 height="40"
                                 class="rounded border ms-2 d-none">

                        {{-- NUMBER TYPE --}}
                        @elseif ($setting->type === 'number')
                            <input type="number"
                                   name="value"
                                   value="{{ $setting->value }}"
                                   class="form-control form-control-sm">

                        {{-- TEXT TYPE --}}
                        @else
                            <input type="text"
                                   name="value"
                                   value="{{ $setting->value }}"
                                   class="form-control form-control-sm">
                        @endif

                        <button class="btn btn-sm btn-success">
                            Update
                        </button>
                    </form>
                </td>

                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>