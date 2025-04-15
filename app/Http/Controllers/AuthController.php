<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signUp(Request $request) 
    {
        return response()->json([
            'message' => 'Sign up successful',
        ], 200);
    }

    public function signIn(Request $request)
    {
        return response()->json([
            'message' => 'Sign in successful',
        ], 200);
    }

    public function signOut(Request $request)
    {
        return response()->json([
            'message' => 'Sign out successful',
        ], 200);
    }
}
