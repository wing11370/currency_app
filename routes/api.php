<?php

use App\Http\Controllers\CurrencyExchangeController;
use Illuminate\Support\Facades\Route;

Route::get('/exchange', [CurrencyExchangeController::class, 'exchange']);