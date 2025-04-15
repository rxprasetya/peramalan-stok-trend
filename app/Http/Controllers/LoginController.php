<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 

class LoginController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }else{
            return view('login.login');
        }
    }

    public function login(Request $request)
    {
        # code...
        $request->validate([
            'name' => 'required|max:64',
            'password' => 'required|min:8|max:16',
          ]);

        $credentials = $request->only(['name', 'password']);

        if (Auth::Attempt($credentials)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->with('error', 'Username or your Password is wrong!');
        }
    }

    public function logout()
    {
        # code...
        Auth::logout();
        return redirect()->route('login');
    }
}
