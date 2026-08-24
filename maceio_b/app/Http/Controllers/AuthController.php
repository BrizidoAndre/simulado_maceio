<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (!auth()->guest()) {
            return redirect()->route('admin.index');
        }
        return view('auth.login');
    }

    public function logon(Request $request)
    {
        $data = $request->validate([
            'username' => ['required',],
            'password' => ['required',],
        ]);
        $user = User::where('username', $data['username'])->first();
        if (!$user || !\Hash::check($data['password'], $user->password)) {
            return back()->with('danger', 'Invalid credentials.');
        }
        auth()->login($user);
        return redirect()->route('admin.index');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('public.index');
    }
}
