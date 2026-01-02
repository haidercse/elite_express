<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('backend.pages.users.index', compact('users', 'roles'));
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->input('status'),
        ]);

        $user->roles()->sync($request->roles ?? []);

        return response()->json(['status' => 'success']);
    }

    public function updateAjax(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$id",
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->input('status'),
        ]);

        if ($request->password) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        $user->roles()->sync($request->roles ?? []);

        return response()->json(['status' => 'success']);
    }

    public function deleteAjax($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['status' => 'success']);
    }


    public function profileModal($id)
    {
        $user = User::with('profile', 'roles')->findOrFail($id);

        return view('backend.pages.users.profile-modal', compact('user'));
    }

    public function profileEditModal($id)
    {
        $user = User::with('profile')->findOrFail($id);
        return view('backend.pages.users.profile-edit', compact('user'));
    }

    public function profileUpdate(UpdateUserProfileRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user->profile) {
            $user->profile()->create([]);
        }

        $profile = $user->profile;

        $profile->fill($request->only([
            'phone',
            'dob',
            'gender',
            'address',
            'nid_number',
            'passport_number',
            'salary',
            'salary_type',
            'employment_type',
            'joining_date'
        ]));

        if ($request->hasFile('profile_photo')) {
            $profile->profile_photo = uploadFile($request->file('profile_photo'), 'profile');
        }

        if ($request->hasFile('nid_document')) {
            $profile->nid_document = uploadFile($request->file('nid_document'), 'nid');
        }

        if ($request->hasFile('contract_document')) {
            $profile->contract_document = uploadFile($request->file('contract_document'), 'contracts');
        }

        $profile->save();

        return response()->json(['success' => true]);
    }

    public function list()
    {
        $users = User::with('roles')->get();
        return view('backend.pages.users.partials.table', compact('users'));
    }

}
