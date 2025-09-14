<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Auth\CurrentController;
use App\Http\Controllers\V1\Auth\LoginByEmailAndPasswordController;
use App\Http\Controllers\V1\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', LoginByEmailAndPasswordController::class);
Route::post('auth/register', RegisterController::class);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('auth/current', CurrentController::class);
});
