<?php

use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;

/* Route::get('/user', function (Request $request) {
    return $request->user();
}); *///->middleware('auth:sanctum');

//Ruta para el registro de usuarios
Route::post('register', [RegisterController::class, 'store'])-> name('api.v1.register');

//Ruta para el login de usuarios
Route::post('login',[LoginController::class, 'store'])->name('api.v1.login');

Route::get('users', [UserController::class, 'index'])->name('api.v1.user.index');

//Rutas para el CRUD de categorias
Route::apiResource('categories', CategoryController::class)->names('api.v1.categories');
//Rutas para el CRUD de posts
Route::apiResource('posts', PostController::class)->names('api.v1.posts');