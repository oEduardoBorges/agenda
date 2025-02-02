<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('agendas')->group(function () {
    Route::get('/', [AgendaController::class, 'findAll']);
    Route::post('/', [AgendaController::class, 'save']);
    Route::get('/{id}', [AgendaController::class, 'findById']);
    Route::put('/{id}', [AgendaController::class, 'update']);
    Route::delete('/{id}', [AgendaController::class, 'delete']);
});