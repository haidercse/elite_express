<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->get();

        return view('backend.pages.settings.index', compact('settings'));
    }

    public function list()
    {
        $bookingSettings = Setting::where('group', 'booking')->get();
        return view('backend.pages.settings.partials.booking-table', compact('bookingSettings'))->render();
    }
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string',
            'key' => 'required|string|unique:settings,key',
            'group' => 'required|string',
            'type' => 'required|string',
        ]);

        $value = $request->value;

        if ($request->type === 'image' && $request->hasFile('value')) {
            $value = $request->file('value')->store('settings', 'public');
        }

        Setting::create([
            'label' => $request->label,
            'key' => $request->key,
            'group' => $request->group,
            'type' => $request->type,
            'value' => $value,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Setting added successfully'
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'type' => 'required|string',
        ]);

        $setting = Setting::where('key', $request->key)->firstOrFail();

        // Handle image upload
        if ($setting->type === 'image') {

            if ($request->hasFile('value')) {

                // delete old image
                if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);
                }

                // upload new image
                $path = $request->file('value')->store('settings', 'public');

                $setting->update([
                    'value' => $path
                ]);
            }

        } else {
            // text or number
            $setting->update([
                'value' => $request->value
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $setting->label . ' updated successfully'
        ]);
    }
}
