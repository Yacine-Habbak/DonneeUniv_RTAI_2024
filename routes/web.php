<?php

use App\Http\Controllers\RecupApiController;

use Illuminate\Support\Facades\Route;


Route::get('/', [RecupApiController::class, 'RecupData']);