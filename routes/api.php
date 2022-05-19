<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GigController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // User
    Route::get('users/me', [UserController::class, 'getProfile']);
    Route::put('users/me', [UserController::class, 'updateProfile']);

    // Companies
    Route::resource(
        'companies',
        CompanyController::class,
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]
    );

    // Gigs
    Route::get('gigs/search', [GigController::class, 'search']);

    Route::resource(
        'gigs',
        GigController::class,
        ['only' => ['index', 'store', 'show', 'update', 'destroy']]
    );

    // Logout
    Route::post('logout', [AuthenticationController::class, 'logout']);
});
