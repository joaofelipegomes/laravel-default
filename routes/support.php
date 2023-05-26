<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsLoggedOS;
use App\Http\Controllers\Support\AuthController;

Route::middleware(EnsureUserIsLoggedOS::class)->get(
  '/',
  [AuthController::class, 'redirectUser']
);

Route::get(
  '/entrar',
  [AuthController::class, 'loggin']
);
