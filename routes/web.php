<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Task Routes

Route::get('/',[TaskController::class,'index'])->name("home")->middleware("auth");

Route::get('/dashboard', [TaskController::class,'index'])->middleware(['auth'])->name('dashboard');

Route::resource("/task",TaskController::class)->names([
    "index"=>"tasks",
    "create"=>"tasks.create",
    "store"=>"tasks.store",
    "show"=>"tasks.show",
    "edit"=>"tasks.edit",
    "update"=>"tasks.update",
    "destroy"=>"tasks.destroy",
])->middleware("auth");




require __DIR__.'/auth.php';
