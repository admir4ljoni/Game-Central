<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
       Route::post('/signup', [AuthController::class, 'signUp'])->name('auth.signup');
       Route::post('/signin', [AuthController::class, 'signIn'])->name('auth.signin');
       Route::post('/signout', [AuthController::class, 'signOut'])->middleware('auth:sanctum')->name('auth.signout');
    });
    
    // Test route to verify authentication
    Route::get('/user', function (Request $request) {
        return response()->json([
            'message' => 'Authentication successful',
            'user' => $request->user(),
        ]);
    })->middleware('auth:sanctum');
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
