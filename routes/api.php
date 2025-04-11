<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Endpoint login (tidak memerlukan token)
Route::post('/login', [AuthController::class, 'login']);

// Group endpoint yang dilindungi dengan JWT
Route::middleware('auth:api')->group(function () {
    // Info user yang sedang login
    Route::get('/me', [AuthController::class, 'me']);

    // Endpoint logout (memerlukan token)
    Route::post('/logout', [AuthController::class, 'logout']);

    // Endpoint student CRUD yang diproteksi token
    Route::apiResource('/students', StudentController::class);
});
