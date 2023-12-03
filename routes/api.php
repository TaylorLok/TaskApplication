<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\TaskController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use Inertia\Inertia;
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

Route::middleware(['auth'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


// Route::post('/auth/register', [AuthController::class, 'createUser']);

Route::post('auth/register', [AuthController::class, 'createUser']);

Route::post('auth/login', [AuthController::class, 'loginUser']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user-tasks', [TaskController::class, 'ListUserTask']);


    Route::get('/task/{id}', [TaskController::class, 'show']);


    Route::post('/task/create', [TaskController::class, 'store']);


    Route::put('/task/update/{id}', [TaskController::class, 'update']);


    Route::delete('/task/delete/{id}', [TaskController::class, 'delete']);

});
