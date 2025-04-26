<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function signUp(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:administrators|min:4|max:60',
            'password' => 'required|string|min:5|max:20',
        ]);

        $user = Administrator::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'username' => $user->username,
        ], 201);
    }

    public function signIn(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:4|max:60',
            'password' => 'required|string|min:5|max:20',
        ]);

        $user = Administrator::where('username', $request->username)->first();

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

    public function getAdmins()
    {
        $admins = Administrator::select('username', 'last_login_at', 'created_at', 'updated_at')->get();
        
        return response()->json([
            'totalElements' => $admins->count(),
            'content' => $admins
        ], 200);
    }
}
