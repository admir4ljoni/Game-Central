<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function signUp(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users|min:4|max:60',
            'password' => 'required|string|min:5|max:20',
            'role' => 'required|string|in:developer,player',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
        ], 201)->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ]);
    }

    /**
     * Authenticate a user and create a token.
     */
    public function signIn(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:4|max:60',
            'password' => 'required|string|min:5|max:20',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'invalid',
                'message' => 'Wrong username or password'
            ], 401);
        }

        // Update last login timestamp
        $user->last_login_at = now();
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'token' => $token,
        ], 200)->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ]);
    }

    /**
     * Logout the user and revoke the token.
     */
    public function signOut(Request $request)
    {
        // Revoke the token that was used to authenticate the current request
        $request->user()->tokens()->where('name', 'auth_token')->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sign out successful'
        ], 200);
    }
}
