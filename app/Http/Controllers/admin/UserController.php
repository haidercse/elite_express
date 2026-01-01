<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
            'status' => $request->status ?? 1,
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
            'status' => $request->status ?? 1,
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
}
