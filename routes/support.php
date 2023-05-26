<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsValidOS;
use App\Http\Controllers\Support\AuthController;

Route::middleware(EnsureUserIsValidOS::class)->get(
  '/',
  [AuthController::class, 'loggin']
);

Route::middleware(EnsureUserIsValidOS::class)->get(
  '/entrar',
  [AuthController::class, 'loggin']
);
