<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;

Route::get('/properties/search', [PropertyController::class, 'search']);
