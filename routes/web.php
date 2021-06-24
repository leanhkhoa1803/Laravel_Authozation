<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //module user
    Route::prefix('users')->group(function () {
        //list user
        Route::get('/', [UserController::class, 'index'])->name('user.index')
            ->middleware('checkPermission:user_list');

        Route::middleware('checkPermission:user_list,user_add,user_user_edit,user_delete')
            ->group(function () {
                //create user
                Route::get('create', [UserController::class, 'create'])->name('user.create');
                Route::post('create', [UserController::class, 'store'])->name('user.create');

                //edit user
                Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
                Route::post('edit/{id}', [UserController::class, 'update'])->name('user.edit');

                //edit user
                Route::get('delete/{id}', [UserController::class, 'delete'])->name('user.delete');
            });

    });

    Route::prefix('role')->group(function () {
        //list user
        Route::get('/', [RoleController::class, 'index'])->name('role.index')
        ->middleware('checkPermission:role_list');

        //create user
        Route::get('create', [RoleController::class, 'create'])->name('role.create');
        Route::post('create', [RoleController::class, 'store'])->name('role.create');

        //edit user
        Route::get('edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('edit/{id}', [RoleController::class, 'update'])->name('role.edit');

        //edit user
        Route::get('delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
    });
});
require __DIR__ . '/auth.php';
