<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
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

Route::get('status', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API Working'
    ]);
});


Route::post('validate-nit', [DocumentController::class, 'validateNIT']);


Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'create']);
    Route::get('{user}', [UserController::class, 'show']);
    Route::put('{user}', [UserController::class, 'update']);
    Route::delete('{user}', [UserController::class, 'delete']);
});

Route::get('process',[UserManagementController::class, 'process']);

