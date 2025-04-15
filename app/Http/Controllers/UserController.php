<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        # code...
        $user = User::get();
        return view('users.user', compact('user'));
    }

    public function create()
    {
        # code...
        return view('users.fuser');
    }

    public function edit($id)
    {
        # code...
        $user = User::find($id);

        return view('users.fuser', compact('user'));
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'name' => 'required|min:2|max:64',
            'password' => 'required|min:8|max:16',
            'role' => 'required',
        ]);

        $user = User::create([
            'id' => Str::uuid(),
            'name' => $request -> name,
            'password' => $request -> password,
            'role' => $request -> role,
        ]);

        return redirect()
        ->route('user')
        ->with('success', 'Successfully added user');
    }

    public function update(Request $request, $id)
    {
        # code...
        $request->validate([
            'name' => 'required|min:2|max:64',
            'password' => 'required|min:8|max:16',
            'role' => 'required',
        ]);

        $user = User::find($id);
        $user -> update([
            'name' => $request -> name,
            'password' => $request -> password,
            'role' => $request -> role,
        ]);

        return redirect()
        ->route('user')
        ->with('success', 'Successfully updated user');
    }

    public function delete($id)
    {
        # code...
        $user = User::find($id);
        $user->delete();

        return redirect()
        ->route('user');
    }

}
