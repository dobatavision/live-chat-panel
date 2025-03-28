<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ManageController extends Controller
{

    public function index()
    {
        $users = User::all()->map(function ($user) {
            $user->role = $user->getRoleNames()->first();
            return $user;
        });

        return view('manage', compact('users'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user_id,
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::find($request->user_id);

        if ($user) {
            $user->update($request->only(['name', 'email']));
            $user->syncRoles([$request->role]);
        }

        return redirect()->route('manage')->with('success', 'User updated successfully.');
    }
}
