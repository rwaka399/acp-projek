<?php

use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Auth
Route::get('/loginpage', [AuthController::class, 'loginPage'])->name('loginpage');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth.custom')->group(function () {

    Route::get('/', [ViewController::class, 'dashboard'])->name('dashboard');


    Route::prefix('task')->group(function () {
        Route::get('/all', [TaskController::class, 'indexTask'])->name('indexTask');
        Route::get('/create', [TaskController::class, 'create'])->name('task.create');
        Route::post('/store', [TaskController::class, 'store'])->name('task.store');
        Route::get('/show/{id}', [TaskController::class, 'show'])->name('task.show');
        Route::put('/update/{id}', [TaskController::class, 'update'])->name('task.update');
        Route::delete('/delete/{id}', [TaskController::class, 'destroy'])->name('task.delete');
    });

    Route::prefix('manajer')->group(function () {

        Route::prefix('proyek')->group(function () {

            Route::get('/all', [ProyekController::class, 'indexProyek'])->name('indexProyek');
            Route::get('/create', [ProyekController::class, 'create'])->name('proyek.create');
            Route::post('/store', [ProyekController::class, 'store'])->name('proyek.store');
            Route::get('/show/{id}', [ProyekController::class, 'show'])->name('proyek.show');
            Route::put('/update/{id}', [ProyekController::class, 'update'])->name('proyek.update');
            Route::delete('/delete/{id}', [ProyekController::class, 'destroy'])->name('proyek.delete');

        });
    });



    Route::prefix('master')->group(function () {

        Route::prefix('roles')->group(function () {
            Route::get('search', [RoleController::class, 'search'])->name('roles.search');
            Route::get('/all', [RoleController::class, 'indexRole'])->name('indexRole');
            Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
            Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
            Route::get('/show/{id}', [RoleController::class, 'show'])->name('roles.show');
            Route::put('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
            Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('roles.delete');
        });

        Route::prefix('users')->group(function () {
            Route::get('/search', [UserController::class, 'search'])->name('users.search');
            Route::get('/all', [UserController::class, 'listUser'])->name('listUser');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/store', [UserController::class, 'store'])->name('users.store');
            Route::get('/show/{id}', [UserController::class, 'show'])->name('users.show');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');
        });
    });
});
