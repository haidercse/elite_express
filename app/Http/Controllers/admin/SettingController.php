<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // তুমি চাইলে group অনুযায়ী filter করতে পারো
        $bookingSettings = Setting::where('group', 'booking')->get();

        return view('backend.pages.settings.index', compact('bookingSettings'));
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
            'value' => 'nullable',
        ]);

        $setting = Setting::where('key', $request->key)->firstOrFail();
        $setting->update(['value' => $request->value]);

        return response()->json([
            'success' => true,
            'message' => $setting->label . ' updated successfully',
        ]);
    }
}
