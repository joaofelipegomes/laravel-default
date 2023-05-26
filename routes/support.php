<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Support\AuthController;

Route::get(
  '/',
  [AuthController::class, 'loggin']
);
