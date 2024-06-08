<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\LoginController;

Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api|public).*$');

Route::post('/api/login', [LoginController::class, 'login']);

Route::get('/api/nodes', [NodeController::class, 'index']);
Route::get('/api/nodes/limited', [NodeController::class, 'limited']);
Route::post('/api/nodes', [NodeController::class, 'store']);
Route::put('/api/nodes/{id}', [NodeController::class, 'update']);
Route::delete('/api/nodes/{node}', [NodeController::class, 'destroy']);

Route::get('/api/connections', [ConnectionController::class, 'index']);
Route::get('/api/connections/limited', [ConnectionController::class, 'limited']);
Route::post('/api/connections', [ConnectionController::class, 'store']);
Route::delete('/api/connections/{connection}', [ConnectionController::class, 'destroy']);