<?php
use App\Http\Controllers\AlertController;
use Illuminate\Support\Facades\Route;

Route::post('alert', [AlertController::class, 'process'])
    ->middleware(['limit.body', 'restrict.trading-view.ip'])
    ->name('alert-hook');
