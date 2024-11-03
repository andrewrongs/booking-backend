<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function (){
    $authController = \App\Http\Controllers\Auth\accountController::class;
    Route::post('login', [$authController, 'login']);
    Route::post('register', [$authController, 'register']);
    Route::post('reset', [$authController, 'reset']);
    Route::post('forgot', [$authController, 'forgot']);
    Route::post('logout', [$authController, 'logout']);
});