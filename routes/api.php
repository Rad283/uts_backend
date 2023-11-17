<?php

use App\Http\Controllers\PatientsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// group route yang menggunakan middleware sanctum
Route::middleware('auth:sanctum')->group(function () {

    // mengroup route dengan controller yang sama, yaitu PatientsController
    Route::controller(PatientsController::class)->group(function () {
        Route::get('/patients', 'index');
        Route::post('/patients', 'store');
        Route::get('/patients/{id}', 'show');
        Route::put('/patients/{id}', 'update');
        Route::delete('/patients/{id}', 'destroy');
    });

    // Group untuk controller SearchController
    Route::controller(SearchController::class)->group(function () {
        Route::get('patients/search/{name}', 'search');
        Route::get('patients/status/{status}', 'status');
    });
});


// route group untuk login dan register
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});
