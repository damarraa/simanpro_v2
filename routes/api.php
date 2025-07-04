<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Endpoint otentikasi
 */
Route::post('/v1/login', [LoginController::class, 'login']);
Route::post('/v1/register', [LoginController::class, 'register']);

/**
 * Endpoint wajib terotentikasi
 */
Route::middleware('auth:sanctum')->group(function () {
    // Endpoint logout
    Route::post('/v1/logout', [LoginController::class, 'logout']);

    // Endpoint mendapatkan data user yang login
    Route::get('/v1/user', function (Request $request) {
        return $request->user();
    });

    // Endpoint modul projects
    Route::apiResource('/v1/projects', ProjectController::class);
});