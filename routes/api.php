<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
  'middleware' => 'api',
  'prefix' => 'auth'
], function ($router) {
  Route::post('login', [AuthController::class, 'login']);
  // Route::get('users', [AuthController::class, 'users']);
  Route::put('registration', [AuthController::class, 'registration']);
  Route::get('send/{email}', [AuthController::class, 'generateHash']);
});

Route::get('/users', [UserController::class, 'getAll']);
Route::get('/users/{id}', [UserController::class, 'getOne']);
Route::post('/users', [UserController::class, 'create']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'deleteOne']);
Route::delete('/users', [UserController::class, 'deleteAll']);

Route::get('/posts', [PostController::class, 'getAll']);
Route::get('/posts/{id}', [PostController::class, 'getOne']);
Route::post('/posts', [PostController::class, 'create']);
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'delete']);
