<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Logs the user creating a token to be used in all requests
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);
        $user = User::where('username', $data['username'])->first();
        if (!$user || !\Hash::check($data['password'], $user->password)) {
            throw new HttpResponseException(response()->json([
                'error' => 'Unauthorized',
            ], 401));
        }
        $user->update([
            'token' => md5($user->username)
        ]);
        return [
            'token' => $user->token,
        ];
    }

    /**
     * Updates the users token to null
     * @return string[]
     */
    public function logout()
    {
        auth()->user()->update([
            'token' => null,
        ]);
        return [
            'message' => 'Successfully logged out',
        ];
    }
}
