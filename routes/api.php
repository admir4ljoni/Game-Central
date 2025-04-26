<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
       Route::post('/signup', [AuthController::class, 'signUp'])->name('auth.signup');
       Route::post('/signin', [AuthController::class, 'signIn'])->name('auth.signin');
       Route::post('/signout', [AuthController::class, 'signOut'])->middleware('auth:sanctum')->name('auth.signout');
    });

    Route::prefix('admin')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('/signin', [AdminController::class, 'signIn'])->name('admin.auth.signin');
            Route::middleware('auth:sanctum')->group(function () {
                Route::post('/signup', [AdminController::class, 'signUp'])->name('admin.auth.signup');
            });
        });
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/admins', [AdminController::class, 'getAdmins'])->name('admin.getAdmins');
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
