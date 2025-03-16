<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('manage', compact('users'));
    }

    public function update(Request $request)
    {
        foreach ($request->users as $id => $userData) {
            $user = User::find($id);
            $user->update($userData);
        }

        return redirect()->route('manage')->with('success', 'Users updated successfully.');
    }
}
