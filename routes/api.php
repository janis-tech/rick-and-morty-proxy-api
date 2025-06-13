<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('/characters', [\App\Http\Controllers\CharacterController::class, 'index']);
    Route::get('/characters/{id}', [\App\Http\Controllers\CharacterController::class, 'show'])
        ->where('id', '[0-9]+');
    Route::fallback(function () {
        return response()->json([
            'status' => 'error',
            'message' => 'Route not found',
        ], 404);
    });

});
