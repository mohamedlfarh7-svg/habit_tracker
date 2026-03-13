<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\LogHabitController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use function PHPUnit\Framework\returnArgument;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/create', [HabitController::class, 'store']);
    Route::get('/habit', [HabitController::class, 'index']);
    Route::get("/habit/{id}", [HabitController::class, 'show']);
    Route::put("/habit/{habit}", [HabitController::class, 'update']);
    Route::delete("/habit/{habit}", [HabitController::class, 'delete']);

});
