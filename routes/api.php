<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TodoController;

//routes protected by auth middleware 
Route::group(['middleware' => ['auth:api']], function () {
    //all have /auth/ before API name
    Route::group(['prefix' => 'auth'], function () {

        //from AuthController
        Route::controller(AuthController::class)->group(function () {
            Route::post('logout', 'logout');
            Route::post('refresh', 'refresh');
        });

        //from TodoController (to be modified later)
        Route::controller(TodoController::class)->group(function () {
            Route::get('todos', 'index');
            Route::post('todo', 'store');
            Route::get('todo/{id}', 'show');
            Route::put('todo/{id}', 'update');
            Route::delete('todo/{id}', 'destroy');
        });

        //admin API's protected by admin middleware and require /auth/admin/ before API name
        Route::group(['middleware' => ['admin']], function () {
            Route::group(['prefix' => 'admin'], function () {
                Route::get('/users', [AdminController::class, 'users'])->name('users'); 
            });
        });
        
    });
});

//unprotected API routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');